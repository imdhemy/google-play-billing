# Serialization

Applies to: `src/**`, `tests/**`

## Shared serializer

- Serialize request bodies through the shared serializer. Keep JSON mapping in serializer configuration and metadata rather than introducing `JsonSerializable` implementations when the required shape is supported.
- Use `#[Ignore]` on request properties used only for path or query parameters so they are excluded from the body. Configure `ObjectNormalizer` with `ClassMetadataFactory` and `AttributeLoader` to read these attributes.
- Register `BackedEnumNormalizer` before `ObjectNormalizer` to serialize backed enums as their string or integer values. Do not add getters solely to convert enums for serialization.
- For payload shapes that built-in normalizers and metadata cannot express, consider a dedicated normalizer rather than duplicating mapping in domain objects.

## Migration and compatibility

- When touching a class implementing `JsonSerializable`, migrate its JSON mapping toward the shared serializer within the scope of that class.
- Add or update tests before migration to preserve the expected JSON shape, including omitted fields, null and empty values, enum values, and nested objects where applicable.
- Check direct `jsonSerialize()` calls and `json_encode()` usage. Preserving shared serializer output alone does not preserve those entry points. Flag public API breaks before removing the interface or method, and respect the target release's compatibility requirements.
- Keep `JsonSerializableNormalizer` registered while unmigrated classes depend on it. It delegates to their existing `jsonSerialize()` methods; removing it globally can change their output.
- Cover shared serializer capabilities with focused unit tests and request-specific JSON shapes with request serialization tests.
- Follow the session's validation permissions. Suggest targeted tests when running them is not authorized, and report any checks not run.
