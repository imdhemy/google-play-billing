<?php

namespace Imdhemy\GooglePlay\DeveloperNotifications\Contracts;

use Imdhemy\GooglePlay\ValueObjects\Time;

/**
 * Interface RealTimeDeveloperNotification.
 */
interface RealTimeDeveloperNotification
{
    public function getType(): string;

    public function getVersion(): string;

    public function getPackageName(): string;

    public function getEventTime(): Time;

    public function getPayload(): NotificationPayload;
}
