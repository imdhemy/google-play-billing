---
name: document-api-usage
description: Write or maintain library usage guides under docs/ when documenting a public API, operation, or purchase lifecycle.
---

# Document API usage

## Read the context

Read the implementation and relevant existing guide. Use `docs/purchase/` for
task-oriented explanations and PHP examples, but verify examples against current source.
Follow `ai/guidelines/google-api-fidelity.md` for API accuracy and official references.

## Write the guide

- Update an existing guide first. Place new guides under `docs/`, grouped by domain and user task.
- Lead with the reader's task and link to the relevant official Google documentation.
- Show prerequisites and dependency setup once, before use. Identify caller-supplied inputs.
- Use fenced `php` examples with required imports, current public signatures, and meaningful names.
- Organize lifecycle guides by events and backend actions. For individual operations, show inputs, invocation, and returned data or an empty result.
- Explain relevant state checks, follow-up actions, and errors. Keep caveats brief.
- Describe implemented behavior for the target release; keep proposed architecture in design notebooks.
- Keep usage examples in `docs/`, not the root README. Omit PHP tutorials and link new guides from relevant entry points.

## Review

Check example imports, inputs, calls, results, links, and heading anchors.
Ensure snippets have the setup they need and clearly mark application-specific placeholders.
Follow the session's validation permissions and report checks not run.
