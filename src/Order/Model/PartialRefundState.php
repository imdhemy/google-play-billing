<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Order\Model;

/**
 * The state of a partial refund.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/orders#state_1
 */
enum PartialRefundState: string
{
    case UNSPECIFIED = 'STATE_UNSPECIFIED';
    case PENDING = 'PENDING';
    case PROCESSED_SUCCESSFULLY = 'PROCESSED_SUCCESSFULLY';
}
