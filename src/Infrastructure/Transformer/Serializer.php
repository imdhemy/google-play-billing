<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Infrastructure\Transformer;

use Imdhemy\GooglePlay\Domain\Serializer\SerializerInterface;
use Symfony\Component\Serializer as SymfonySerializer;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;

final readonly class Serializer implements SerializerInterface
{
    public function __construct(
        private SymfonySerializer\SerializerInterface $serializer,
    ) {
    }

    public static function create(): self
    {
        $serializer = new SymfonySerializer\Serializer(
            normalizers: [
                new JsonSerializableNormalizer(),
                new SymfonySerializer\Normalizer\ObjectNormalizer(),
            ],
            encoders: [new SymfonySerializer\Encoder\JsonEncoder()],
        );

        return new self($serializer);
    }

    public function serialize(
        mixed $data,
        string $format = 'json',
        array $context = [
            SymfonySerializer\Normalizer\AbstractObjectNormalizer::SKIP_NULL_VALUES => true,
            SymfonySerializer\Normalizer\AbstractObjectNormalizer::PRESERVE_EMPTY_OBJECTS => true,
        ],
    ): string {
        return $this->serializer->serialize($data, $format, $context);
    }
}
