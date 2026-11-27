<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Order\Model;

use DateTimeImmutable;

/**
 * Details of when an order was processed.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/orders#processedevent
 */
final readonly class ProcessedEvent
{
    /**
     * @param DateTimeImmutable|null $eventTime When the order was processed
     */
    public function __construct(
        public ?DateTimeImmutable $eventTime = null,
    ) {
    }
}
