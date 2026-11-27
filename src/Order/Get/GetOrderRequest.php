<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Order\Get;

final readonly class GetOrderRequest
{
    /**
     * @param string $packageName The package name of the application, for example 'com.some.thing'
     * @param string $orderId     The order ID provided to the user when the order was purchased
     */
    public function __construct(
        public string $packageName,
        public string $orderId,
    ) {
    }
}
