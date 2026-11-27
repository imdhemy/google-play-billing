<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Order\Model;

use Imdhemy\GooglePlay\ValueObjects\Money;

/**
 * Details relating to any Play Points applied to an order.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/orders#pointsdetails
 */
final readonly class PointsDetails
{
    /**
     * @param string|null $pointsOfferId            ID unique to the Play Points offer in use
     * @param string|null $pointsSpent              The number of Play Points applied (int64 as a string)
     * @param string|null $pointsDiscountRateMicros The discount rate in micros (int64 as a string)
     * @param Money|null  $pointsCouponValue        The monetary value of the Play Points coupon
     */
    public function __construct(
        public ?string $pointsOfferId = null,
        public ?string $pointsSpent = null,
        public ?string $pointsDiscountRateMicros = null,
        public ?Money $pointsCouponValue = null,
    ) {
    }
}
