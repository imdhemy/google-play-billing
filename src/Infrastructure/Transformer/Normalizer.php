<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Infrastructure\Transformer;

use Imdhemy\GooglePlay\Domain\Serializer\NormalizerInterface;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

final readonly class Normalizer implements NormalizerInterface
{
    public function __construct(private SerializerInterface $serializer)
    {
    }

    public static function create(): self
    {
        return new self(new Serializer([
            new BackedEnumNormalizer(),
            new TimeNormalizer(),
            new ObjectNormalizer(propertyTypeExtractor: new PhpDocExtractor()),
            new ArrayDenormalizer(),
        ], [new JsonEncoder()]));
    }

    /**
     * Deserializes data into the given type.
     *
     * @template TObject of object
     * @template TType of string|class-string<TObject>
     *
     * @param TType $type
     *
     * @phpstan-return ($type is class-string<TObject> ? TObject : mixed)
     *
     * @psalm-return (TType is class-string<TObject> ? TObject : mixed)
     *
     * @psalm-suppress MixedReturnStatement
     */
    public function normalize(mixed $data, string $type): mixed
    {
        $json = json_encode($data, JSON_PARTIAL_OUTPUT_ON_ERROR);

        return $this->serializer->deserialize($json, $type, 'json');
    }
}
