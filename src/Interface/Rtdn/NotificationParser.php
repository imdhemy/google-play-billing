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
        $data = $cloudMessage['message']['data'] ?? throw new InvalidArgumentException('Missing "message.data" key in cloud message.');
        $decodedData = base64_decode($data, true);

        if (false === $decodedData) {
            throw new InvalidArgumentException('Invalid base64 encoded data.');
        }

        $notificationData = json_decode($decodedData, true, 512, JSON_THROW_ON_ERROR);

        return $this->normalizer->normalize($notificationData, DeveloperNotification::class);
    }
}
