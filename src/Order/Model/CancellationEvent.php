<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Order\Model;

use DateTimeImmutable;

/**
 * Details of when an order was canceled.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/orders#cancellationevent
 */
final readonly class CancellationEvent
{
    /**
     * @param DateTimeImmutable|null $eventTime When the order was canceled
     */
    public function __construct(
        public ?DateTimeImmutable $eventTime = null,
    ) {
    }
}
