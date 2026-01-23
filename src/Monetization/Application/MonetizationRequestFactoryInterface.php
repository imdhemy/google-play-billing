<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Monetization\Application;

use InvalidArgumentException;
use Psr\Http\Message\RequestInterface;

interface MonetizationRequestFactoryInterface
{
    /**
     * @throws InvalidArgumentException - when the provided data is not supported
     */
    public function create(object $data): RequestInterface;
}
