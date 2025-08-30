#!/bin/bash

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Script configuration
SCRIPT_NAME="$(basename "$0")"
VERSION=""
DRY_RUN=false

# Print colored output
print_info() {
    echo -e "${BLUE}ℹ ${1}${NC}"
}

print_success() {
    echo -e "${GREEN}✅ ${1}${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠️ ${1}${NC}"
}

print_error() {
    echo -e "${RED}❌ ${1}${NC}"
}

print_step() {
    echo -e "\n${BLUE}🔧 ${1}${NC}"
}

# Show usage information
usage() {
    cat << EOF
Usage: $SCRIPT_NAME <version|increment> [options]

Create a new release for the Filament Browser Timezone package.

Arguments:
  version               Version number (semantic versioning: x.y.z)
  increment             Semantic version increment: major, minor, or patch

Options:
  --dry-run            Show what would be done without making changes
  -h, --help           Show this help message

Examples:
  $SCRIPT_NAME 1.2.3           # Explicit version
  $SCRIPT_NAME major           # Increment major version (1.0.0 -> 2.0.0)
  $SCRIPT_NAME minor           # Increment minor version (1.0.0 -> 1.1.0)
  $SCRIPT_NAME patch           # Increment patch version (1.0.0 -> 1.0.1)
  $SCRIPT_NAME patch --dry-run # Test patch increment

EOF
}

# Get current version from git tags
get_current_version() {
    local current_version
    current_version=$(git describe --tags --abbrev=0 2>/dev/null | sed 's/^v//')
    
    if [[ -z "$current_version" ]]; then
        current_version="0.0.0"
    fi
    
    echo "$current_version"
}

# Increment version based on type
increment_version() {
    local version="$1"
    local increment_type="$2"
    
    IFS='.' read -r major minor patch <<< "$version"
    
    case $increment_type in
        major)
            major=$((major + 1))
            minor=0
            patch=0
            ;;
        minor)
            minor=$((minor + 1))
            patch=0
            ;;
        patch)
            patch=$((patch + 1))
            ;;
        *)
            print_error "Invalid increment type: $increment_type"
            print_info "Valid increment types: major, minor, patch"
            return 1
            ;;
    esac
    
    echo "$major.$minor.$patch"
}

# Validate semantic version format
validate_version() {
    local version="$1"
    
    if [[ ! $version =~ ^[0-9]+\.[0-9]+\.[0-9]+$ ]]; then
        print_error "Invalid version format: $version"
        print_info "Version must follow semantic versioning (x.y.z), e.g., 1.2.3"
        return 1
    fi
    
    return 0
}


# Check if git working directory is clean and up to date
check_git_status() {
    print_step "Checking git repository status..."
    
    if ! git rev-parse --is-inside-work-tree &>/dev/null; then
        print_error "Not inside a git repository"
        return 1
    fi
    
    # Check for uncommitted changes
    if ! git diff --quiet || ! git diff --cached --quiet; then
        print_warning "Working directory is not clean. Uncommitted changes found:"
        git status --short
        echo
        if $DRY_RUN; then
            print_info "[DRY RUN] Would commit and push current changes before release"
        else
            read -p "Commit and push these changes before release? (y/N): " -n 1 -r
            echo
            if [[ $REPLY =~ ^[Yy]$ ]]; then
                # We need to determine the version first for the commit message
                local temp_version="$VERSION"
                case $VERSION in
                    major|minor|patch)
                        local current_version
                        current_version=$(get_current_version)
                        if [[ -z "$current_version" ]]; then
                            current_version="0.0.0"
                        fi
                        temp_version=$(increment_version "$current_version" "$VERSION")
                        ;;
                esac
                commit_message="Release $temp_version changes"
                
                print_step "Committing current changes..."
                git add -A
                git commit -m "$commit_message"
                
                print_step "Pulling latest changes from remote..."
                if ! git pull origin "$current_branch"; then
                    print_error "Failed to pull changes. There may be conflicts to resolve."
                    print_info "Please resolve conflicts manually and run the release script again."
                    return 1
                fi
                
                print_step "Pushing current changes..."
                if ! git push origin; then
                    print_error "Failed to push changes. Please resolve manually."
                    return 1
                fi
                print_success "Current changes committed and pushed"
            else
                print_info "Release cancelled. Please commit or stash changes first."
                return 1
            fi
        fi
    fi
    
    # Check if branch is up to date with remote
    print_info "Checking if branch is up to date with remote..."
    local current_branch
    current_branch=$(git rev-parse --abbrev-ref HEAD)
    
    # Fetch latest from remote
    if ! git fetch origin "$current_branch" &>/dev/null; then
        print_warning "Could not fetch from remote. Continuing without remote check."
    else
        local local_commit
        local remote_commit
        local_commit=$(git rev-parse HEAD)
        remote_commit=$(git rev-parse "origin/$current_branch" 2>/dev/null)
        
        if [[ "$local_commit" != "$remote_commit" ]]; then
            if git merge-base --is-ancestor HEAD "origin/$current_branch" 2>/dev/null; then
                print_error "Your branch is behind 'origin/$current_branch'. Please pull the latest changes first."
                print_info "Run: git pull origin $current_branch"
                return 1
            elif git merge-base --is-ancestor "origin/$current_branch" HEAD 2>/dev/null; then
                print_info "Your branch is ahead of 'origin/$current_branch'. This is expected for a release."
            else
                print_error "Your branch and 'origin/$current_branch' have diverged."
                print_info "Please resolve conflicts and sync with remote before releasing."
                return 1
            fi
        fi
    fi
    
    # Check for untracked files that might be important
    local untracked_files
    untracked_files=$(git ls-files --others --exclude-standard)
    if [[ -n "$untracked_files" ]]; then
        print_warning "Untracked files found:"
        echo "$untracked_files"
        read -p "Continue with release? (y/N): " -n 1 -r
        echo
        if [[ ! $REPLY =~ ^[Yy]$ ]]; then
            print_info "Release cancelled"
            return 1
        fi
    fi
    
    print_success "Git repository is ready for release"
    return 0
}

# Check GitHub CLI authentication
check_gh_auth() {
    print_step "Checking GitHub CLI authentication..."
    
    if ! command -v gh &> /dev/null; then
        print_error "GitHub CLI (gh) is not installed"
        print_info "Please install GitHub CLI: https://cli.github.com/"
        return 1
    fi
    
    if ! gh auth status &>/dev/null; then
        print_error "GitHub CLI is not authenticated"
        print_info "Please run: gh auth login"
        return 1
    fi
    
    print_success "GitHub CLI is authenticated"
    return 0
}

# Update version in composer.json
update_composer_version() {
    local version="$1"
    
    print_step "Updating version in composer.json..."
    
    if [[ ! -f "composer.json" ]]; then
        print_warning "composer.json not found, skipping version update"
        return 0
    fi
    
    if $DRY_RUN; then
        print_info "[DRY RUN] Would update composer.json version to $version"
        return 0
    fi
    
    # Use sed to update version in composer.json
    if command -v jq &> /dev/null; then
        # Use jq if available for safer JSON manipulation
        local temp_file
        temp_file=$(mktemp)
        jq --arg version "$version" '.version = $version' composer.json > "$temp_file"
        mv "$temp_file" composer.json
    else
        # Fallback to sed
        sed -i.bak "s/\"version\":[[:space:]]*\"[^\"]*\"/\"version\": \"$version\"/" composer.json
        rm -f composer.json.bak
    fi
    
    print_success "Updated composer.json version to $version"
    return 0
}

# Commit changes with release message
commit_changes() {
    local version="$1"
    
    print_step "Committing release changes..."
    
    if $DRY_RUN; then
        print_info "[DRY RUN] Would commit changes with message: 'Release version $version'"
        return 0
    fi
    
    git add .
    git commit -m "Release version $version

🤖 Generated with Claude Code (https://claude.ai/code)

Co-Authored-By: Claude <noreply@anthropic.com>"
    
    print_success "Committed changes for version $version"
    return 0
}

# Create git tag
create_tag() {
    local version="$1"
    local tag_name="v$version"
    
    print_step "Creating git tag $tag_name..."
    
    if git rev-parse "$tag_name" &>/dev/null; then
        print_error "Tag $tag_name already exists"
        return 1
    fi
    
    if $DRY_RUN; then
        print_info "[DRY RUN] Would create tag: $tag_name"
        return 0
    fi
    
    git tag -a "$tag_name" -m "Release version $version"
    
    print_success "Created tag $tag_name"
    return 0
}

# Push changes and tags to origin
push_to_origin() {
    local version="$1"
    
    print_step "Pushing changes and tags to origin..."
    
    if $DRY_RUN; then
        print_info "[DRY RUN] Would push commits and tags to origin"
        return 0
    fi
    
    git push origin
    git push origin "v$version"
    
    print_success "Pushed changes and tags to origin"
    return 0
}

# Create GitHub release
create_github_release() {
    local version="$1"
    local tag_name="v$version"
    
    print_step "Creating GitHub release..."
    
    if $DRY_RUN; then
        print_info "[DRY RUN] Would create GitHub release for $tag_name"
        return 0
    fi
    
    # Generate release notes
    local release_notes="Release version $version

## What's Changed
- Version bump to $version

**Full Changelog**: https://github.com/$(gh repo view --json owner,name --jq '.owner.login + "/" + .name')/compare/$(git describe --tags --abbrev=0 HEAD^ 2>/dev/null || echo 'HEAD')...$tag_name

---
🤖 Generated with [Claude Code](https://claude.ai/code)"
    
    gh release create "$tag_name" \
        --title "Release $version" \
        --notes "$release_notes" \
        --latest
    
    print_success "Created GitHub release for $tag_name"
    print_info "Release URL: $(gh release view "$tag_name" --json url --jq '.url')"
    
    return 0
}

# Rollback on failure
rollback() {
    local version="$1"
    local tag_name="v$version"
    
    print_warning "Rolling back due to failure..."
    
    # Remove tag if it was created
    if git rev-parse "$tag_name" &>/dev/null; then
        git tag -d "$tag_name" || true
        print_info "Removed local tag $tag_name"
    fi
    
    # Reset to previous commit if we made one
    if git log --oneline -1 | grep -q "Release version $version"; then
        git reset --hard HEAD~1
        print_info "Reset to previous commit"
    fi
    
    print_error "Release process failed and has been rolled back"
}

# Main release function
main() {
    local version="$1"
    
    print_info "🚀 Starting release process for version $version"
    
    if $DRY_RUN; then
        print_warning "DRY RUN MODE - No changes will be made"
    fi
    
    # Run pre-flight checks
    if ! check_git_status; then
        return 1
    fi
    
    if ! check_gh_auth; then
        return 1
    fi
    
    # Confirm release
    if [[ ! $DRY_RUN ]]; then
        echo
        print_warning "About to create release $version"
        read -p "Continue? (y/N): " -n 1 -r
        echo
        if [[ ! $REPLY =~ ^[Yy]$ ]]; then
            print_info "Release cancelled"
            return 0
        fi
    fi
    
    # Execute release steps with error handling
    {
        update_composer_version "$version" &&
        commit_changes "$version" &&
        create_tag "$version" &&
        push_to_origin "$version" &&
        create_github_release "$version"
    } || {
        if [[ ! $DRY_RUN ]]; then
            rollback "$version"
        fi
        return 1
    }
    
    print_success "🎉 Successfully released version $version!"
    
    if $DRY_RUN; then
        print_info "This was a dry run. No actual changes were made."
    fi
}

# Parse command line arguments
while [[ $# -gt 0 ]]; do
    case $1 in
        --dry-run)
            DRY_RUN=true
            shift
            ;;
        -h|--help)
            usage
            exit 0
            ;;
        -*)
            print_error "Unknown option: $1"
            usage
            exit 1
            ;;
        *)
            if [[ -z "$VERSION" ]]; then
                VERSION="$1"
            else
                print_error "Too many arguments"
                usage
                exit 1
            fi
            shift
            ;;
    esac
done

# Validate arguments
if [[ -z "$VERSION" ]]; then
    print_error "Version number or increment type is required"
    usage
    exit 1
fi

# Resolve version (handle both explicit versions and increments)
case $VERSION in
    major|minor|patch)
        print_step "Resolving $VERSION version increment..."
        CURRENT_VERSION=$(get_current_version)
        if [[ -z "$CURRENT_VERSION" ]]; then
            CURRENT_VERSION="0.0.0"
            print_info "No existing tags found, starting from $CURRENT_VERSION"
        else
            print_info "Current version: $CURRENT_VERSION"
        fi
        NEW_VERSION=$(increment_version "$CURRENT_VERSION" "$VERSION")
        if [[ -z "$NEW_VERSION" ]]; then
            exit 1
        fi
        print_info "$VERSION: $CURRENT_VERSION -> $NEW_VERSION"
        VERSION="$NEW_VERSION"
        ;;
esac

if ! validate_version "$VERSION"; then
    exit 1
fi

# Run the main function
main "$VERSION"