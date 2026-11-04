<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Order\Model;

/**
 * The pricing phase of a subscription billing period.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/orders#offerphase
 */
enum OfferPhase: string
{
    case UNSPECIFIED = 'OFFER_PHASE_UNSPECIFIED';
    case BASE = 'BASE';
    case INTRODUCTORY = 'INTRODUCTORY';
    case FREE_TRIAL = 'FREE_TRIAL';
}
