<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Order\Model;

use Imdhemy\GooglePlay\ValueObjects\Money;

/**
 * Details of a line item.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/orders#lineitem
 */
final readonly class LineItem
{
    /**
     * @param string|null                 $productTitle           Developer-specified name of the product, in the buyer's locale
     * @param string|null                 $productId              The purchased product ID or in-app SKU
     * @param Money|null                  $listingPrice           The listed price on Play Store, which may or may not include tax
     * @param Money|null                  $total                  The total amount paid for this line item, after discounts and taxes
     * @param Money|null                  $tax                    The tax paid for this line item
     * @param PaidAppDetails|null         $paidAppDetails         Details of a paid app purchase
     * @param OneTimePurchaseDetails|null $oneTimePurchaseDetails Details of a one-time purchase
     * @param SubscriptionDetails|null    $subscriptionDetails    Details of a subscription purchase
     */
    public function __construct(
        public ?string $productTitle = null,
        public ?string $productId = null,
        public ?Money $listingPrice = null,
        public ?Money $total = null,
        public ?Money $tax = null,
        public ?PaidAppDetails $paidAppDetails = null,
        public ?OneTimePurchaseDetails $oneTimePurchaseDetails = null,
        public ?SubscriptionDetails $subscriptionDetails = null,
    ) {
    }
}
