<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Order\Model;

/**
 * Details about events which modified an order.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/orders#orderhistory
 */
final readonly class OrderHistory
{
    /**
     * @param ProcessedEvent|null           $processedEvent      When the order was processed
     * @param CancellationEvent|null        $cancellationEvent   When the order was canceled
     * @param RefundEvent|null              $refundEvent         When the order was fully refunded
     * @param list<PartialRefundEvent>|null $partialRefundEvents The partial refund events for the order
     */
    public function __construct(
        public ?ProcessedEvent $processedEvent = null,
        public ?CancellationEvent $cancellationEvent = null,
        public ?RefundEvent $refundEvent = null,
        public ?array $partialRefundEvents = null,
    ) {
    }
}
