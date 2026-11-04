<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Order\Model;

use DateTimeImmutable;

/**
 * Details of when an order was fully refunded.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/orders#refundevent
 */
final readonly class RefundEvent
{
    /**
     * @param DateTimeImmutable|null $eventTime     When the order was fully refunded
     * @param RefundDetails|null     $refundDetails Details for the full refund
     * @param RefundReason|null      $refundReason  The reason the order was refunded
     */
    public function __construct(
        public ?DateTimeImmutable $eventTime = null,
        public ?RefundDetails $refundDetails = null,
        public ?RefundReason $refundReason = null,
    ) {
    }
}
