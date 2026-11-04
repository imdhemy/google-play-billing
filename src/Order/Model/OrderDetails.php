<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Order\Model;

/**
 * Detailed information about an order at creation time.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/orders#orderdetails
 */
final readonly class OrderDetails
{
    /**
     * @param bool|null $taxInclusive Whether the listed price was tax inclusive
     */
    public function __construct(
        public ?bool $taxInclusive = null,
    ) {
    }
}
