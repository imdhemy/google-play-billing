<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain;

interface SerializerInterface
{
    /**
     * Serializes data in the appropriate format.
     *
     * @param array<string, mixed> $context Options normalizers/encoders have access to
     */
    public function serialize(mixed $data, string $format = 'json', array $context = []): string;
}
