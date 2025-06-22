<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Rtdn\Notification;

use Imdhemy\GooglePlay\Domain\Rtdn\Type\SubscriptionNotificationType;

/**
 * @see https://developer.android.com/google/play/billing/rtdn-reference#sub
 */
final readonly class SubscriptionNotification
{
    public function __construct(
        public string $version,
        public SubscriptionNotificationType $notificationType,
        public string $purchaseToken,
    ) {
    }
}
