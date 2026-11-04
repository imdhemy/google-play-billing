<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Order\Model;

use Imdhemy\GooglePlay\ValueObjects\Money;

/**
 * Details for a partial or full refund.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/orders#refunddetails
 */
final readonly class RefundDetails
{
    /**
     * @param Money|null $total The total amount refunded, including tax
     * @param Money|null $tax   The amount of tax refunded
     */
    public function __construct(
        public ?Money $total = null,
        public ?Money $tax = null,
    ) {
    }
}
