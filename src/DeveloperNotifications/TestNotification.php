<?php

namespace Imdhemy\GooglePlay\DeveloperNotifications;

use Imdhemy\GooglePlay\DeveloperNotifications\Contracts\NotificationPayload;

/**
 * TestNotification class
 * Test Notification
 * {@link https://developer.android.com/google/play/billing/rtdn-reference#test}.
 */
class TestNotification implements NotificationPayload
{
    public const TEST_NOTIFICATION_TYPE = -1;

    /**
     * @var string
     */
    protected $version;

    /**
     * TestNotification constructor.
     */
    public function __construct(string $version)
    {
        $this->version = $version;
    }

    public static function create(array $attributes): TestNotification
    {
        return new self($attributes['version']);
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getType(): string
    {
        return self::TEST_NOTIFICATION;
    }

    public function getNotificationType(): int
    {
        return self::TEST_NOTIFICATION_TYPE;
    }
}
