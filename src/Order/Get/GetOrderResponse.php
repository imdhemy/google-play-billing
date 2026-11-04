<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Order\Get;

use Imdhemy\GooglePlay\Order\Model\Order;

final readonly class GetOrderResponse
{
    public function __construct(
        public Order $order,
    ) {
    }
}
