<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Order\Model;

/**
 * The reason an order was refunded.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/orders#refundreason
 */
enum RefundReason: string
{
    case UNSPECIFIED = 'REFUND_REASON_UNSPECIFIED';
    case OTHER = 'OTHER';
    case CHARGEBACK = 'CHARGEBACK';
}
