<?php

namespace Imdhemy\GooglePlay\DeveloperNotifications\Builders;

use Imdhemy\GooglePlay\DeveloperNotifications\Contracts\NotificationPayload;
use Imdhemy\GooglePlay\DeveloperNotifications\Contracts\RealTimeDeveloperNotification;
use Imdhemy\GooglePlay\DeveloperNotifications\DeveloperNotification;
use Imdhemy\GooglePlay\DeveloperNotifications\Exceptions\InvalidDeveloperNotificationArgumentException;
use Imdhemy\GooglePlay\DeveloperNotifications\Factories\NotificationPayloadFactory;
use TypeError;

/**
 * Class DeveloperNotificationBuilder
 * @psalm-suppress MissingConstructor
 */
final class DeveloperNotificationBuilder
{
    /**
     * @var string
     */
    private $version;

    /**
     * @var string
     */
    private $packageName;

    /**
     * @var int
     */
    private $eventTimeMillis;

    /**
     * @var NotificationPayload
     */
    private $payload;

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
        return $this->version;
    }

    /**
     * @param string $version
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
        return $this->packageName;
    }

    /**
     * @param string $packageName
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
        return $this->eventTimeMillis;
    }

    /**
     * @param int $eventTimeMillis
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
        return $this->payload;
    }

    /**
     * @param NotificationPayload $payload
     * @return DeveloperNotificationBuilder
     */
    public function setPayload(NotificationPayload $payload): DeveloperNotificationBuilder
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * @param array $data
     * @return DeveloperNotificationBuilder
     */
    public function setPayloadFromArray(array $data): DeveloperNotificationBuilder
    {
        $this->payload = NotificationPayloadFactory::create($data);

        return $this;
    }

    /**
     * @return DeveloperNotification
     * @throws InvalidDeveloperNotificationArgumentException
     */
    public function build(): RealTimeDeveloperNotification
    {
        try {
            return new DeveloperNotification($this);
        } catch (TypeError $typeError) {
            throw InvalidDeveloperNotificationArgumentException::fromTypeError($typeError);
        }
    }
}
