<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Rtdn\Notification;

use Imdhemy\GooglePlay\Domain\Rtdn\Type\OneTimeProductNotificationType;

/**
 * @see https://developer.android.com/google/play/billing/rtdn-reference#one-time
 */
final readonly class OneTimeProductNotification
{
    public function __construct(
        public string $version,
        public OneTimeProductNotificationType $notificationType,
        public string $purchaseToken,
        public string $sku,
    ) {
    }
}
