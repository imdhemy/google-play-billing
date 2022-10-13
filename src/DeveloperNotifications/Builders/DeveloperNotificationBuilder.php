<?php

namespace Imdhemy\GooglePlay\DeveloperNotifications\Builders;

use Imdhemy\GooglePlay\DeveloperNotifications\Contracts\NotificationPayload;
use Imdhemy\GooglePlay\DeveloperNotifications\Contracts\RealTimeDeveloperNotification;
use Imdhemy\GooglePlay\DeveloperNotifications\DeveloperNotification;
use Imdhemy\GooglePlay\DeveloperNotifications\Exceptions\InvalidDeveloperNotificationArgumentException;
use Imdhemy\GooglePlay\DeveloperNotifications\Factories\NotificationPayloadFactory;

/**
 * Class DeveloperNotificationBuilder
 *
 * @psalm-suppress MissingConstructor
 */
final class DeveloperNotificationBuilder
{
    /**
     * @var string|null
     */
    private ?string $version = null;

    /**
     * @var string|null
     */
    private ?string $packageName = null;

    /**
     * @var int|null
     */
    private ?int $eventTimeMillis = null;

    /**
     * @var NotificationPayload|null
     */
    private ?NotificationPayload $payload = null;

    /**
     * @var array|null
     */
    private ?array $decodedData = null;

    /**
     * @return static
     */
    public static function init(): self
    {
        return new self();
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        if ($this->version === null) {
            $message = $this->buildMessage('version');

            throw new InvalidDeveloperNotificationArgumentException($message);
        }

        return $this->version;
    }

    /**
     * @param string $version
     *
     * @return DeveloperNotificationBuilder
     */
    public function setVersion(string $version): DeveloperNotificationBuilder
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @return string
     */
    public function getPackageName(): string
    {
        if ($this->packageName === null) {
            $message = $this->buildMessage('packageName');

            throw new InvalidDeveloperNotificationArgumentException($message);
        }

        return $this->packageName;
    }

    /**
     * @param string $packageName
     *
     * @return DeveloperNotificationBuilder
     */
    public function setPackageName(string $packageName): DeveloperNotificationBuilder
    {
        $this->packageName = $packageName;

        return $this;
    }

    /**
     * @return int
     */
    public function getEventTimeMillis(): int
    {
        if ($this->eventTimeMillis === null) {
            $message = $this->buildMessage('eventTimeMillis');

            throw new InvalidDeveloperNotificationArgumentException($message);
        }

        return $this->eventTimeMillis;
    }

    /**
     * @param int $eventTimeMillis
     *
     * @return DeveloperNotificationBuilder
     */
    public function setEventTimeMillis(int $eventTimeMillis): DeveloperNotificationBuilder
    {
        $this->eventTimeMillis = $eventTimeMillis;

        return $this;
    }

    /**
     * @return NotificationPayload
     */
    public function getPayload(): NotificationPayload
    {
        if ($this->payload === null) {
            $message = $this->buildMessage('payload');

            throw new InvalidDeveloperNotificationArgumentException($message);
        }

        return $this->payload;
    }

    /**
     * @param NotificationPayload $payload
     *
     * @return DeveloperNotificationBuilder
     */
    public function setPayload(NotificationPayload $payload): DeveloperNotificationBuilder
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * @param array $data
     *
     * @return DeveloperNotificationBuilder
     */
    public function setPayloadFromArray(array $data): DeveloperNotificationBuilder
    {
        $this->payload = NotificationPayloadFactory::create($data);

        return $this;
    }

    /**
     * @return array
     */
    public function getDecodedData(): array
    {
        if ($this->decodedData === null) {
            $message = $this->buildMessage('decodedData');

            throw new InvalidDeveloperNotificationArgumentException($message);
        }

        return $this->decodedData;
    }

    /**
     * @param array $decodedData
     *
     * @return DeveloperNotificationBuilder
     */
    public function setDecodedData(array $decodedData): DeveloperNotificationBuilder
    {
        $this->decodedData = $decodedData;

        return $this;
    }

    /**
     * @return DeveloperNotification
     * @throws InvalidDeveloperNotificationArgumentException
     */
    public function build(): RealTimeDeveloperNotification
    {
        return new DeveloperNotification($this);
    }

    /**
     * @param string $argument
     *
     * @return string
     */
    public function buildMessage(string $argument): string
    {
        return sprintf(
            "The property `%s` is required, use the %s::set%s() to set it",
            $argument,
            self::class,
            ucfirst($argument)
        );
    }
}
