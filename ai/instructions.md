# Project guidance

The committed `ai/` directory is the source of truth for this project's AI guidance.
Follow all baseline guidelines included in this entry point for every applicable task.
Guidelines and matching rules are requirements.

## Project rules

Before planning or creating or editing files:

1. Read `ai/rules/index.md`, when present.
2. Read every rule file whose path globs match the files in scope.
3. Search `ai/rules/` for relevant domain, operation, and task keywords to find rules that path matching alone may miss.
4. Follow all applicable rules before proceeding.

Where guidelines and rules leave a choice open, find and follow a matching project pattern. Existing patterns do not override these requirements.

## Skills

Use the published skills available through your agent's native skill discovery.
Activate skills whose descriptions match the task and read their instructions before proceeding.

Canonical skill sources live in `ai/skills/`.

## Maintaining guidance

Edit guidance under `ai/`, never its generated copies.
Run `composer ai:publish -- <agent>` after changing guidance or adapters, using the desired directory name under `ai/adapters/`.
The agent argument is required. Publishing overwrites generated entry points and skills.
