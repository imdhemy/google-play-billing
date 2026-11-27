<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Order\Model;

/**
 * The state of an order.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/orders#state
 */
enum OrderState: string
{
    case UNSPECIFIED = 'STATE_UNSPECIFIED';
    case PENDING = 'PENDING';
    case PROCESSED = 'PROCESSED';
    case CANCELED = 'CANCELED';
    case PENDING_REFUND = 'PENDING_REFUND';
    case PARTIALLY_REFUNDED = 'PARTIALLY_REFUNDED';
    case REFUNDED = 'REFUNDED';
}
