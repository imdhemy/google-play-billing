<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * @see https://developers.google.cn/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#acknowledgementstate
 */
enum AcknowledgementState: string
{
    case UNSPECIFIED = 'ACKNOWLEDGEMENT_STATE_UNSPECIFIED';
    case PENDING = 'ACKNOWLEDGEMENT_STATE_PENDING';
    case ACKNOWLEDGED = 'ACKNOWLEDGEMENT_STATE_ACKNOWLEDGED';
}
