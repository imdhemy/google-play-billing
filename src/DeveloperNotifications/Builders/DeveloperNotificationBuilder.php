<?php

namespace Imdhemy\GooglePlay\DeveloperNotifications\Builders;

use Imdhemy\GooglePlay\DeveloperNotifications\Contracts\NotificationPayload;
use Imdhemy\GooglePlay\DeveloperNotifications\Contracts\RealTimeDeveloperNotification;
use Imdhemy\GooglePlay\DeveloperNotifications\DeveloperNotification;
use Imdhemy\GooglePlay\DeveloperNotifications\Exceptions\InvalidDeveloperNotificationArgumentException;
use Imdhemy\GooglePlay\DeveloperNotifications\Factories\NotificationPayloadFactory;

/**
 * Class DeveloperNotificationBuilder.
 *
 * @psalm-suppress MissingConstructor
 */
final class DeveloperNotificationBuilder
{
    private ?string $version = null;

    private ?string $packageName = null;

    private ?int $eventTimeMillis = null;

    private ?NotificationPayload $payload = null;

    private ?array $decodedData = null;

    /**
     * @return static
     */
    public static function init(): self
    {
        return new self();
    }

    public function getVersion(): string
    {
        if (null === $this->version) {
            $message = $this->buildMessage('version');

            throw new InvalidDeveloperNotificationArgumentException($message);
        }

        return $this->version;
    }

    public function setVersion(string $version): DeveloperNotificationBuilder
    {
        $this->version = $version;

        return $this;
    }

    public function getPackageName(): string
    {
        if (null === $this->packageName) {
            $message = $this->buildMessage('packageName');

            throw new InvalidDeveloperNotificationArgumentException($message);
        }

        return $this->packageName;
    }

    public function setPackageName(string $packageName): DeveloperNotificationBuilder
    {
        $this->packageName = $packageName;

        return $this;
    }

    public function getEventTimeMillis(): int
    {
        if (null === $this->eventTimeMillis) {
            $message = $this->buildMessage('eventTimeMillis');

            throw new InvalidDeveloperNotificationArgumentException($message);
        }

        return $this->eventTimeMillis;
    }

    public function setEventTimeMillis(int $eventTimeMillis): DeveloperNotificationBuilder
    {
        $this->eventTimeMillis = $eventTimeMillis;

        return $this;
    }

    public function getPayload(): NotificationPayload
    {
        if (null === $this->payload) {
            $message = $this->buildMessage('payload');

            throw new InvalidDeveloperNotificationArgumentException($message);
        }

        return $this->payload;
    }

    public function setPayload(NotificationPayload $payload): DeveloperNotificationBuilder
    {
        $this->payload = $payload;

        return $this;
    }

    public function setPayloadFromArray(array $data): DeveloperNotificationBuilder
    {
        $this->payload = NotificationPayloadFactory::create($data);

        return $this;
    }

    public function getDecodedData(): array
    {
        if (null === $this->decodedData) {
            $message = $this->buildMessage('decodedData');

            throw new InvalidDeveloperNotificationArgumentException($message);
        }

        return $this->decodedData;
    }

    public function setDecodedData(array $decodedData): DeveloperNotificationBuilder
    {
        $this->decodedData = $decodedData;

        return $this;
    }

    /**
     * @return DeveloperNotification
     *
     * @throws InvalidDeveloperNotificationArgumentException
     */
    public function build(): RealTimeDeveloperNotification
    {
        return new DeveloperNotification($this);
    }

    public function buildMessage(string $argument): string
    {
        return sprintf(
            'The property `%s` is required, use the %s::set%s() to set it',
            $argument,
            self::class,
            ucfirst($argument)
        );
    }
}
