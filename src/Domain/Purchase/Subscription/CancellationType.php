<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase\Subscription;

/**
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptions/cancel#cancellationtype
 */
enum CancellationType: string
{
    case UNSPECIFIED = 'CANCELLATION_TYPE_UNSPECIFIED';
    case USER_REQUESTED_STOP_RENEWALS = 'USER_REQUESTED_STOP_RENEWALS';
    case DEVELOPER_REQUESTED_STOP_PAYMENTS = 'DEVELOPER_REQUESTED_STOP_PAYMENTS';
}
