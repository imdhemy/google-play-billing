<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase\Entity;

use Imdhemy\GooglePlay\Domain\Purchase\Product\AcknowledgementState;
use Imdhemy\GooglePlay\Domain\Purchase\Product\ConsumptionState;
use Imdhemy\GooglePlay\Domain\Purchase\Product\PurchaseState;
use Imdhemy\GooglePlay\Domain\Purchase\Product\PurchaseType;
use Imdhemy\GooglePlay\ValueObjects as GooglePlay;

/**
 * A ProductPurchase resource indicates the status of a user's inapp product purchase.
 *
 * @see https://developers.google.cn/android-publisher/api-ref/rest/v3/purchases.products#resource:-productpurchase
 */
final readonly class ProductPurchase
{
    public function __construct(
        public string $kind,
        public GooglePlay\Time $purchaseTimeMillis,
        public PurchaseState $purchaseState,
        public ConsumptionState $consumptionState,
        public string $orderId,
        public PurchaseType $purchaseType,
        public AcknowledgementState $acknowledgementState,
        public string $regionCode,
        public ?string $purchaseToken = null,
        public ?string $productId = null,
        public int $quantity = 1,
        public string $developerPayload = '',
        public ?string $obfuscatedExternalAccountId = null,
        public ?string $obfuscatedExternalProfileId = null,
        public ?int $refundableQuantity = null,
    ) {
    }
}
