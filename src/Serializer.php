<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer as SymfonySerializer;
use Symfony\Component\Serializer\SerializerInterface;

final readonly class Serializer implements SerializerInterface
{
    public function __construct(private SymfonySerializer $serializer)
    {
    }

    public static function create(): self
    {
        return new self(new SymfonySerializer([new ObjectNormalizer()], [new JsonEncoder()]));
    }

    public function deserialize(mixed $data, string $type, string $format = 'json', array $context = []): mixed
    {
        $json = is_array($data) ? json_encode($data, JSON_PARTIAL_OUTPUT_ON_ERROR) : $data;

        return $this->serializer->deserialize($json, $type, $format, $context);
    }

    public function serialize(mixed $data, string $format, array $context = []): string
    {
        return $this->serializer->serialize($data, $format, $context);
    }
}
