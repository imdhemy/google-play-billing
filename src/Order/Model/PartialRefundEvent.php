<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Order\Model;

use DateTimeImmutable;

/**
 * Details of a partial refund event for an order.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/orders#partialrefundevent
 */
final readonly class PartialRefundEvent
{
    /**
     * @param DateTimeImmutable|null  $createTime    When the partial refund was created
     * @param DateTimeImmutable|null  $processTime   When the partial refund was processed
     * @param PartialRefundState|null $state         The state of the partial refund
     * @param RefundDetails|null      $refundDetails Details for the partial refund
     */
    public function __construct(
        public ?DateTimeImmutable $createTime = null,
        public ?DateTimeImmutable $processTime = null,
        public ?PartialRefundState $state = null,
        public ?RefundDetails $refundDetails = null,
    ) {
    }
}
