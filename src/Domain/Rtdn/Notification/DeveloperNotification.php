<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Rtdn\Notification;

use Imdhemy\GooglePlay\ValueObjects\Time;

/**
 * @see https://developer.android.com/google/play/billing/rtdn-reference#encoding
 */
final readonly class DeveloperNotification
{
    public function __construct(
        public string $version,
        public string $packageName,
        public Time $eventTimeMillis,
        public ?OneTimeProductNotification $oneTimeProductNotification = null,
        public ?SubscriptionNotification $subscriptionNotification = null,
        public ?VoidedPurchaseNotification $voidedPurchaseNotification = null,
        public ?TestNotification $testNotification = null,
    ) {
    }
}
