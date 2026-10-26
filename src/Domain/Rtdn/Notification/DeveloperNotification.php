<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Rtdn\Notification;

use DateTimeImmutable;
use Imdhemy\GooglePlay\ValueObjects\Time;

/**
 * @see https://developer.android.com/google/play/billing/rtdn-reference#encoding
 *
 * @psalm-suppress DeprecatedClass Retained for backward compatibility until the next major release.
 */
final readonly class DeveloperNotification
{
    public DateTimeImmutable $occurredAt;

    public function __construct(
        public string $version,
        public string $packageName,
        /** @deprecated Use {@see self::$occurredAt} instead. */
        public Time $eventTimeMillis,
        public ?OneTimeProductNotification $oneTimeProductNotification = null,
        public ?SubscriptionNotification $subscriptionNotification = null,
        public ?VoidedPurchaseNotification $voidedPurchaseNotification = null,
        public ?TestNotification $testNotification = null,
    ) {
        $this->occurredAt = DateTimeImmutable::createFromTimestamp((float)$eventTimeMillis->originalValue / 1000);
    }
}
