<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Order\Model;

use DateTimeImmutable;
use Imdhemy\GooglePlay\ValueObjects\Money;

/**
 * Information about a transaction made on Google Play.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/orders#Order
 */
final readonly class Order
{
    /**
     * @param string|null            $orderId                         The order ID
     * @param string|null            $purchaseToken                   The purchase token provided to the user's device
     * @param OrderState|null        $state                           The state of the order
     * @param DateTimeImmutable|null $createTime                      When the order was created
     * @param DateTimeImmutable|null $lastEventTime                   When the last event on the order occurred
     * @param BuyerAddress|null      $buyerAddress                    Customer address information for tax computation
     * @param Money|null             $total                           The final amount paid, after discounts and taxes
     * @param Money|null             $tax                             The total tax paid
     * @param OrderDetails|null      $orderDetails                    Details about the order at creation time
     * @param OrderHistory|null      $orderHistory                    Details about events which modified the order
     * @param list<LineItem>|null    $lineItems                       The line items making up the order
     * @param SalesChannel|null      $salesChannel                    The originating sales channel of the order
     * @param PointsDetails|null     $pointsDetails                   Play Points applied to the order
     * @param Money|null             $developerRevenueInBuyerCurrency Developer revenue in the buyer's currency, net of partial refunds
     */
    public function __construct(
        public ?string $orderId = null,
        public ?string $purchaseToken = null,
        public ?OrderState $state = null,
        public ?DateTimeImmutable $createTime = null,
        public ?DateTimeImmutable $lastEventTime = null,
        public ?BuyerAddress $buyerAddress = null,
        public ?Money $total = null,
        public ?Money $tax = null,
        public ?OrderDetails $orderDetails = null,
        public ?OrderHistory $orderHistory = null,
        public ?array $lineItems = null,
        public ?SalesChannel $salesChannel = null,
        public ?PointsDetails $pointsDetails = null,
        public ?Money $developerRevenueInBuyerCurrency = null,
    ) {
    }
}
