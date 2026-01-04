<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\Domain\Purchase\Subscription\ItemBasedRefund;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ItemBasedRefundTest extends TestCase
{
    #[test]
    public function create(): void
    {
        $productId = $this->faker->uuid();

        $itemBasedRefund = ItemBasedRefund::forProduct($productId);

        $this->assertSame($productId, $itemBasedRefund->productId);
    }
}
