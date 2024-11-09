<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer as SymfonySerializer;

final readonly class Serializer
{
    public function __construct(private SymfonySerializer $serializer)
    {
    }

    public static function create(): self
    {
        return new self(new SymfonySerializer([new ObjectNormalizer()], [new JsonEncoder()]));
    }

    public function deserialize(mixed $data, string $type): mixed
    {
        return $this->serializer->deserialize($data, $type, 'json');
    }
}
