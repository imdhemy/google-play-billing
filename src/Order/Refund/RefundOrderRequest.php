<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Order\Refund;

final readonly class RefundOrderRequest
{
    /**
     * @param string $packageName The package name of the application for which this subscription or in-app item was
     *                            purchased (for example, 'com.some.thing').
     * @param string $orderId     the order ID provided to the user when the subscription or in-app order was purchased
     * @param bool   $revoke      Whether to revoke the purchased item. If set to true, access to the subscription or
     *                            in-app item will be terminated immediately. If the item is a recurring subscription,
     *                            all future payments will also be terminated. Consumed in-app items need to be handled
     *                            by developer's app.
     */
    public function __construct(
        public string $packageName,
        public string $orderId,
        public bool $revoke = false,
    ) {
    }
}
