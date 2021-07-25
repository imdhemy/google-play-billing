<?php


namespace Imdhemy\GooglePlay\DeveloperNotifications;

use Imdhemy\GooglePlay\DeveloperNotifications\Contracts\NotificationPayload;

class TestNotification implements NotificationPayload
{
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
}
