<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Monetization\Onetimeproducts\Domain\Enums;

/**
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/ProductUpdateLatencyTolerance
 */
enum ProductUpdateLatencyTolerance: string
{
    case UNSPECIFIED = 'PRODUCT_UPDATE_LATENCY_TOLERANCE_UNSPECIFIED';
    case SENSITIVE = 'PRODUCT_UPDATE_LATENCY_TOLERANCE_LATENCY_SENSITIVE';
    case TOLERANT = 'PRODUCT_UPDATE_LATENCY_TOLERANCE_LATENCY_TOLERANT';
}
