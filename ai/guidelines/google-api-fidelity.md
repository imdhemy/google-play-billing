# Google API fidelity

This library adapts the Google Play Developer API. Implement its documented contract faithfully.

- Read the relevant official method and resource documentation before implementing or changing an API mapping. Add precise `@see` links to the corresponding source classes or methods.
- Preserve Google's terminology, field names, types, enum values, required/optional status, defaults, and input/output restrictions. Follow project conventions for PHP class names and architecture.
- Match documented HTTP methods, paths, parameter locations, headers, request bodies, and response handling.
- Preserve representations of identifiers, money, timestamps, and large numbers without lossy conversions. Follow documented JSON encodings, including strings for `int64` values.
- Derive test expectations from the documented contract rather than copying assumptions from the implementation.
- Identify public API breaks when correcting mismatches and target the appropriate release.

Use the [official API reference](https://developers.google.com/android-publisher/api-ref/rest) as the primary source. Supplement it with the linked Discovery document for schema details. If sources conflict or leave behavior unclear, report the uncertainty rather than inventing a contract.

## Documentation mismatches

When working on a file, check its relevant API mapping against Google's documentation. For a confirmed mismatch:

1. Check for an existing GitHub issue or PR to avoid duplicates.
2. Report the documented versus implemented behavior in a GitHub issue, with official source links.
3. Open a focused fix PR linked to the issue, targeting the appropriate release. Keep unrelated fixes separate from the current change.
