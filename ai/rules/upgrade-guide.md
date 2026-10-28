# Upgrade guide

Applies to: `src/**`, `UPGRADE-*.md`

- Identify the source and target releases. Update the target major release's guide with each relevant public API deprecation or breaking change. Extend an existing entry before adding another.
- Write from the target release's post-release perspective: removed APIs **have been removed**, not merely deprecated or awaiting removal. Omit transitional coexistence; show old APIs only as migration references or before examples.
- Tell callers what to replace, rename, remove, or migrate. Identify the replacement or supported alternative, or state that none exists. Cover signature, return-type, and behavior changes; an import change may not be enough.
- Focus on the new library API and required caller changes. Assume PHP proficiency; omit language, standard-library, and general programming tutorials.
- Follow existing topic headings and likelihood-of-impact formatting. Use concise tables or before/after examples; omit implementation history.
- Verify replacements against the target release's API. Separate confirmed release decisions from proposals; do not invent replacements or claim planned APIs are implemented.
