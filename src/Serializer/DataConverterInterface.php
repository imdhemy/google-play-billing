<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Serializer;

interface DataConverterInterface
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
     */
    public function convert(array $data, string $type): mixed;
}
