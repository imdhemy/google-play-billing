<?php

namespace Imdhemy\GooglePlay\DeveloperNotifications;

use Imdhemy\GooglePlay\DeveloperNotifications\Contracts\NotificationPayload;

/**
 * TestNotification class
 * Test Notification
 * {@link https://developer.android.com/google/play/billing/rtdn-reference#test}
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
     * @param string $version
     */
    public function __construct(string $version)
    {
        $this->version = $version;
    }

    /**
     * @param array $attributes
     * @return TestNotification
     */
    public static function create(array $attributes): TestNotification
    {
        return new self($attributes['version']);
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return self::TEST_NOTIFICATION;
    }

    /**
     * @inheritDoc
     */
    public function getNotificationType(): int
    {
        return self::TEST_NOTIFICATION_TYPE;
    }
}
