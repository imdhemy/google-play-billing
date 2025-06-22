<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Rtdn\Notification;

use Imdhemy\GooglePlay\Domain\Rtdn\Type\ProductType;
use Imdhemy\GooglePlay\Domain\Rtdn\Type\RefundType;

/**
 * @see https://developer.android.com/google/play/billing/rtdn-reference#voided-purchase
 */
final readonly class VoidedPurchaseNotification
{
    public function __construct(
        public string $purchaseToken,
        public string $orderId,
        public ProductType $productType,
        public RefundType $refundType,
    ) {
    }
}
