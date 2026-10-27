# Unit tests

Applies to: `tests/**`

- Before adding tests for a change, check whether existing tests can be updated or extended to cover it.
- Name test cases in plain English describing the behavior. The test file should read as documentation for the unit it tests.
- Follow Arrange–Act–Assert (AAA).
- Separate the phases with blank lines; omit phase-label comments.
- Keep Act to one line invoking a single entry point.
- Use PHPUnit's `expectException()` and related expectations instead of `try`/`catch`. Place expectations before Act.
