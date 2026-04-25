<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Monetization\Application;

use Imdhemy\GooglePlay\Monetization\Application\ConvertRegionPrices\ConvertRegionPricesQuery;
use Psr\Http\Message\RequestInterface;

interface MonetizationRequestFactoryInterface
{
    public function createConvertRegionPricesRequest(ConvertRegionPricesQuery $query): RequestInterface;
}
