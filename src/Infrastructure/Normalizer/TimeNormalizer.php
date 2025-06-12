<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Infrastructure\Normalizer;

use Imdhemy\GooglePlay\ValueObjects\Time;
use InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class TimeNormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): Time
    {
        if (! is_string($data)) {
            throw new InvalidArgumentException('Expected a string value for Time normalization.');
        }

        return new Time($data);
    }

    public function supportsDenormalization(
        mixed $data,
        string $type,
        ?string $format = null,
        array $context = [],
    ): bool {
        return Time::class === $type && is_string($data);
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Time::class => true,
        ];
    }
}
