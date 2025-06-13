<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\ItemBasedRefund;
use Tests\TestCase;

final class ItemBasedRefundTest extends TestCase
{
    /** @test */
    public function create(): void
    {
        $productId = $this->faker->uuid();

        $itemBasedRefund = ItemBasedRefund::forProduct($productId);

        $this->assertSame($productId, $itemBasedRefund->productId);
    }
}
