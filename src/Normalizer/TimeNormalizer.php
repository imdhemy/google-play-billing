<?php

namespace Imdhemy\GooglePlay\Normalizer;

use Imdhemy\GooglePlay\ValueObjects\Time;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class TimeNormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): Time
    {
        assert(is_string($data));

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
