<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Order\Model;

/**
 * The developer's preference on whether Google Play should grant a refund.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/orders/reviewrefund#refundpreference
 */
enum RefundPreference: string
{
    case UNSPECIFIED = 'REFUND_PREFERENCE_UNSPECIFIED';
    case DECLINE = 'DECLINE';
    case APPROVE = 'APPROVE';
    case NEUTRAL = 'NEUTRAL';
}
