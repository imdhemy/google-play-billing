<?php

namespace Imdhemy\GooglePlay\DeveloperNotifications\Contracts;

use Imdhemy\GooglePlay\ValueObjects\Time;

/**
 * Interface RealTimeDeveloperNotification
 * @package Imdhemy\GooglePlay\DeveloperNotifications
 * @since 2.0.0
 */
interface RealTimeDeveloperNotification
{
    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return string
     */
    public function getVersion(): string;

    /**
     * @return string
     */
    public function getPackageName(): string;

    /**
     * @return Time
     */
    public function getEventTime(): Time;

    /**
     * @return NotificationPayload
     */
    public function getPayload(): NotificationPayload;
}
