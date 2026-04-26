<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Monetization\Application\ConvertRegionPrices;

use Psr\Http\Message\RequestInterface;

interface ConvertRegionPricesRequestFactoryInterface
{
    public function create(ConvertRegionPricesQuery $query): RequestInterface;
}
