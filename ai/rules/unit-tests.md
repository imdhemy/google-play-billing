# Unit tests

Applies to: `tests/**`

## Test scope and naming

- Before adding tests for a change, check whether existing tests can be updated or extended to cover it.
- Name test cases in plain English describing the behavior. The test file should read as documentation for the unit it tests.

## Test structure

- Follow Arrange–Act–Assert (AAA).
- Separate the phases with blank lines; omit phase-label comments.
- Keep Act to one line invoking a single entry point.

## Assertions

- Use PHPUnit's `expectException()` and related expectations instead of `try`/`catch`. Place expectations before Act.

### HTTP request assertions

Use `assertClientSentRequest()` to assert outgoing HTTP requests. Avoid separate assertions for properties it already checks.

If an assertion is missing:

1. Consider extending `assertClientSentRequest()` when the check belongs to request comparison.
2. Otherwise, consider a reusable helper when the check has a clear shared use.
3. For a test-specific check, use a direct PHPUnit assertion.
