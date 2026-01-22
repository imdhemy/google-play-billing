<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Monetization\Application;

use Psr\Http\Message\RequestInterface;

interface MonetizationRequestFactoryInterface
{
    public function create(object $data): RequestInterface;
}
