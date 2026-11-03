# Serialization

Applies to: `src/**`, `tests/**`

## Shared serializer

- Serialize request bodies through the shared serializer. Prefer its configuration and metadata over new `JsonSerializable` implementations.
- Alias `Symfony\Component\Serializer\Attribute` as `Serialization` and qualify attributes with it.
- Exclude path-only and query-only properties with `#[Serialization\Ignore]`.
- Let the shared serializer handle backed enums; do not add serialization-only getters.

## Migration and compatibility

- When touching a `JsonSerializable` class, migrate its mapping toward the shared serializer within that class's scope.
- Before migration, add or update JSON-shape tests for applicable omissions, nulls, empty values, enums, and nested objects.
- Check direct `jsonSerialize()` and `json_encode()` usage. Flag public API breaks before removing the interface or method; respect target-release compatibility.
- Keep `JsonSerializableNormalizer` registered while unmigrated classes depend on it.
- Unit-test shared serializer behavior and test request-specific JSON shapes separately.
- Follow session validation permissions. Suggest targeted tests when execution is unauthorized; report checks not run.
