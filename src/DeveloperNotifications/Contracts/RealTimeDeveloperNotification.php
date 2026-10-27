<?php

namespace Imdhemy\GooglePlay\DeveloperNotifications\Contracts;

use DateTimeImmutable;
use Imdhemy\GooglePlay\ValueObjects\Time;

/**
 * Interface RealTimeDeveloperNotification.
 *
 * @method DateTimeImmutable getOccurredAt()
 *
 * @deprecated
 */
interface RealTimeDeveloperNotification
{
    public function getType(): string;

    public function getVersion(): string;

    public function getPackageName(): string;

    /**
     * @psalm-suppress DeprecatedClass Retained for backward compatibility until the next major release.
     */
    public function getEventTime(): Time;

    public function getPayload(): NotificationPayload;
}
