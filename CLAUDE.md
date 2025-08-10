# Development Context for Claude

This file provides context for Claude to assist with development tasks.
Generated on: 2025-08-10 02:41:04

## Referenced Files

Please read the following project files for complete context:

**Core Configuration:**
- [@.zeri/project.md](.zeri/project.md) - Project overview, tech stack, and architecture
- [@.zeri/development.md](.zeri/development.md) - Standards, decisions, patterns, and development workflows



---

## Instructions for Claude

When working on this project:

1. **Follow the established patterns** described in the patterns section
2. **Adhere to coding standards** outlined in the standards section
3. **Consider architectural decisions** when proposing changes
4. **Follow the development workflow** for implementation steps
5. **Reference current priorities** to align with project goals
6. **Check active specifications** for feature-specific requirements
7. **ONLY implement or start coding when files in .zeri/specs are referenced** - Do not write code without specific feature specifications

## ⚠️ MANDATORY: Specification Creation Rules

**CRITICAL:** When creating new feature specifications, you MUST follow these rules:

### Creating Specifications
**⚠️ MANDATORY: Always use `zeri add-spec <name>` to create new feature specifications.**

**DO NOT manually create specification files. Use the command:**

```bash
# Create a new specification
zeri add-spec "feature-name"

# This creates .zeri/specs/feature-name.md with the standard template
```

### Specification Workflow
1. **⚠️ REQUIRED: Create Specification**: ALWAYS use `zeri add-spec` command to create structured requirements
2. **Plan Implementation**: Break down requirements into actionable tasks
3. **Implement Features**: Follow the TODO checklist step by step
4. **Mark Progress**: Update TODOs in real-time during development
5. **Review and Complete**: Ensure all requirements are met

### Implementation Process Rules
- **MANDATORY**: Always use `zeri add-spec` command - never manually create .md files in .zeri/specs/
- Always start with a specification for non-trivial features
- Break complex features into smaller, manageable tasks
- Follow established coding patterns and conventions
- Write tests alongside implementation

### ⚠️ Important: TODO Marking Requirements
**ALWAYS mark TODO items as complete when implementing specifications in `.zeri/specs/`:**

- Mark checkboxes as `- [x]` when completing each implementation step
- This helps track progress and manage AI assistant usage limits
- Essential for efficient development workflow with AI assistance
- Update TODOs in real-time during implementation, not after completion

## Key Reminders

- Primarily edit files in the .zeri/ directory - NEVER remove zeri file references from generated AI files (CLAUDE.md, GEMINI.md, cursor-zeri.mdc)
- Generated AI files can be edited but preserve all .zeri/ file references and mandatory instructions
- Always write tests for new functionality
- Follow the established code review process
- Consider performance and security implications
- Update documentation when making architectural changes
- Communicate clearly about implementation decisions

---
*This context file is automatically generated from your .zeri configuration. Update the source files in .zeri/ to modify this content.*