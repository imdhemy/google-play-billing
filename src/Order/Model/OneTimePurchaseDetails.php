<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Order\Model;

/**
 * Details of a one-time purchase.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/orders#onetimepurchasedetails
 */
final readonly class OneTimePurchaseDetails
{
    /**
     * @param int|null             $quantity         The number of items purchased
     * @param string|null          $offerId          The offer ID of the one-time purchase offer
     * @param string|null          $purchaseOptionId The ID of the purchase option
     * @param RentalDetails|null   $rentalDetails    Set only for a rental purchase
     * @param PreorderDetails|null $preorderDetails  Set only for a pre-order purchase
     */
    public function __construct(
        public ?int $quantity = null,
        public ?string $offerId = null,
        public ?string $purchaseOptionId = null,
        public ?RentalDetails $rentalDetails = null,
        public ?PreorderDetails $preorderDetails = null,
    ) {
    }
}
