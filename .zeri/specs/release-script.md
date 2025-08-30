# Feature Specification: release-script

## Overview
Create a comprehensive release script (`release.sh`) that automates the entire release process for the Filament Browser Timezone package. This script will handle committing changes, pushing to origin, tagging releases, and creating GitHub releases, ensuring a consistent and error-free release workflow.

## Requirements

### Core Functionality
- **Version Management**: Accept version number as parameter (e.g., `./release.sh 1.2.3`)
- **Git Operations**: Automatically commit staged changes with proper release message
- **Push to Origin**: Push commits and tags to the remote repository
- **Tagging**: Create git tags following semantic versioning
- **GitHub Release**: Create GitHub release with release notes
- **Validation**: Pre-flight checks for clean working directory and valid version format

### User Interface Requirements
- **Command Line Interface**: Simple usage pattern `./release.sh <version>`
- **Progress Feedback**: Clear progress indicators for each step
- **Error Handling**: Informative error messages with recovery suggestions
- **Confirmation Prompts**: Ask for confirmation before destructive operations

### Integration Requirements
- **GitHub CLI**: Use `gh` command for GitHub release creation
- **Git Integration**: Standard git commands for tagging and pushing
- **Package Files**: Update version in relevant package files (composer.json, etc.)
- **Changelog**: Automatic changelog generation or prompt for manual update

### Security & Validation Requirements
- **Version Format**: Validate semantic versioning format (x.y.z)
- **Repository State**: Ensure working directory is clean before release
- **Authentication**: Verify GitHub CLI authentication
- **Backup Safety**: Ability to rollback on failure

## Implementation Notes

### Technical Dependencies
- Git installed and configured
- GitHub CLI (`gh`) installed and authenticated
- Bash shell environment
- Standard Unix utilities (grep, sed, etc.)

### Files to Create/Modify
- **New File**: `release.sh` - Main release script
- **Potential Updates**: `composer.json` - Version number update
- **Potential Updates**: `CHANGELOG.md` - Automated or manual changelog updates

### Script Structure
1. **Input Validation**: Version format, git status checks
2. **Pre-flight Checks**: GitHub auth, clean working directory
3. **Version Updates**: Update package files with new version
4. **Git Operations**: Commit, tag, and push changes
5. **GitHub Release**: Create release with notes and assets
6. **Success/Failure Handling**: Cleanup and rollback on errors

### Integration Points
- Must work with existing git repository structure
- Should integrate with current development workflow
- Compatible with GitHub repository settings and permissions

### Testing Strategy
- Manual testing with different version scenarios
- Dry-run mode for testing without actual releases
- Error condition testing (network issues, auth failures, etc.)

## TODO
- [x] Create basic release.sh script structure
- [x] Implement version validation and input handling
- [x] Add pre-flight checks (git status, gh auth)
- [x] Implement git operations (commit, tag, push)
- [x] Add GitHub release creation functionality
- [x] Implement error handling and rollback mechanisms
- [x] Add progress indicators and user feedback
- [x] Test script with various scenarios
- [x] Add documentation and usage instructions
- [x] Review and refine script functionality