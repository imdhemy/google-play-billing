<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase\Subscription\OfferPhase;

/**
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#originalofferphasetype
 */
enum OriginalOfferPhaseType: string
{
    case UNSPECIFIED = 'ORIGINAL_OFFER_PHASE_TYPE_UNSPECIFIED';
    case BASE = 'BASE';
    case INTRODUCTORY = 'INTRODUCTORY';
    case TRIAL = 'FREE_TRIAL';
}
