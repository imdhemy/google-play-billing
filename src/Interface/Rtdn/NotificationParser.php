<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Interface\Rtdn;

use Imdhemy\GooglePlay\Domain\Rtdn\Notification\DeveloperNotification;
use Imdhemy\GooglePlay\Infrastructure\Transformer\Normalizer;
use InvalidArgumentException;
use JsonException;

final readonly class NotificationParser
{
    public function __construct(private Normalizer $normalizer)
    {
    }

    /**
     * @throws JsonException
     */
    public function parse(array $cloudMessage): DeveloperNotification
    {
        $notificationData = $this->extractNotificationData($cloudMessage);

        return $this->normalizer->normalize($notificationData, DeveloperNotification::class);
    }

    private function extractNotificationData(array $cloudMessage): array
    {
        $data = $cloudMessage['message']['data'] ?? throw new InvalidArgumentException('Missing "message.data" key in cloud message.');

        if (! is_string($data)) {
            throw new InvalidArgumentException('The "message.data" value must be a string.');
        }

        $decodedData = base64_decode($data, true);

        if (false === $decodedData) {
            throw new InvalidArgumentException('Invalid base64 encoded data.');
        }

        $notificationData = json_decode($decodedData, true, 512, JSON_THROW_ON_ERROR);
        if (! is_array($notificationData)) {
            throw new InvalidArgumentException('Decoded data must be an array.');
        }

        return $notificationData;
    }
}
