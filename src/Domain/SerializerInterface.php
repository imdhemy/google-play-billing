<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain;

use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;

interface SerializerInterface
{
    /**
     * Serializes data in the appropriate format.
     *
     * @param array<string, mixed> $context Options normalizers/encoders have access to
     *
     * @throws NotNormalizableValueException Occurs when a value cannot be normalized
     * @throws UnexpectedValueException      Occurs when a value cannot be encoded
     * @throws ExceptionInterface            Occurs for all the other cases of serialization-related errors
     */
    public function serialize(mixed $data, string $format, array $context = []): string;
}
