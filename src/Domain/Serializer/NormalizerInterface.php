<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Serializer;

interface NormalizerInterface
{
    /**
     * Deserializes data into the given type.
     *
     * @template TObject of object
     * @template TType of string|class-string<TObject>
     *
     * @param TType $type
     *
     * @psalm-return (TType is class-string<TObject> ? TObject : mixed)
     *
     * @phpstan-return ($type is class-string<TObject> ? TObject : mixed)
     *
     * @psalm-suppress MixedReturnStatement
     */
    public function normalize(mixed $data, string $type): mixed;
}
