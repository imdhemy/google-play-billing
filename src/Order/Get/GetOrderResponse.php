<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Order\Get;

use Imdhemy\GooglePlay\Order\Model\Order;

final readonly class GetOrderResponse
{
    /**
     * @param Order  $order The order mapped into typed models
     * @param string $body  The unmodified response body, for values the typed models cannot represent exactly
     */
    public function __construct(
        public Order $order,
        public string $body,
    ) {
    }
}
