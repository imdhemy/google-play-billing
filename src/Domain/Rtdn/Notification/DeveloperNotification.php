<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Rtdn\Notification;

use DateTimeImmutable;
use Imdhemy\GooglePlay\ValueObjects\Time;

/**
 * @see https://developer.android.com/google/play/billing/rtdn-reference#encoding
 */
final readonly class DeveloperNotification
{
    public DateTimeImmutable $eventOccurredAt;

    public function __construct(
        public string $version,
        public string $packageName,
        /** @deprecated Use $eventOccurredAt instead. */
        public Time $eventTimeMillis,
        public ?OneTimeProductNotification $oneTimeProductNotification = null,
        public ?SubscriptionNotification $subscriptionNotification = null,
        public ?VoidedPurchaseNotification $voidedPurchaseNotification = null,
        public ?TestNotification $testNotification = null,
    ) {
        $this->eventOccurredAt = DateTimeImmutable::createFromTimestamp((float)$eventTimeMillis->originalValue / 1000);
    }
}
