---
name: add-agent-adapter
description: Create or update an AI agent adapter using the project's shared instructions and native skills.
---

# Add an agent adapter

## Check requirements

Read `ai/instructions.md`, `ai/publish.sh`, and an existing adapter.
Verify the target agent's entry-point path, native skill discovery path,
and skill format against its official documentation.

Shared skills use `<skill-name>/SKILL.md` with `name` and `description`
frontmatter. If that format is incompatible, report the mismatch before
changing the publisher.

## Create the adapter

Create `ai/adapters/<agent>/` with a lowercase, hyphenated name.
Mirror the agent's expected project-root layout:

- Link its entry point directly to `ai/instructions.md`.
- Link its native skills directory to `ai/skills/`.
- Use relative symlinks calculated from each link's parent directory.
- Add only required agent-specific configuration; keep shared content
  in its canonical location.
- Add generated destinations to the root `.gitignore`.

The publisher follows symlinks, embeds baseline guidelines in the entry
point, and replaces corresponding project-root entries, including whole
directories. Include only paths publishing should own.

Compatible adapters require no publisher changes, mappings, or registry.

## Verify manually

When validation is authorized, publish in the development container:

    composer ai:publish -- <agent>

The argument must match the adapter directory name.

Check that:

- The entry point contains shared instructions and baseline guidelines.
- The target agent discovers the published skills and supporting files.
- Generated output is ignored by Git; canonical sources are unchanged.
- Republishing overwrites modified output and removes stale skills.

Report any checks not run. Keep publisher verification manual.
