<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Serializer;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

final readonly class DataConverter implements DataConverterInterface
{
    public function __construct(private SerializerInterface $serializer)
    {
    }

    public static function create(): self
    {
        return new self(new Serializer([new ObjectNormalizer()], [new JsonEncoder()]));
    }

    /**
     * @psalm-suppress MixedReturnStatement
     */
    public function convert(array $data, string $type): mixed
    {
        $json = json_encode($data, JSON_PARTIAL_OUTPUT_ON_ERROR);

        return $this->serializer->deserialize($json, $type, 'json');
    }
}
