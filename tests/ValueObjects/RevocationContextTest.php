<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\RevocationContext;
use Tests\TestCase;

final class RevocationContextTest extends TestCase
{
    /** @test */
    public function full_refund(): void
    {
        $actual = RevocationContext::fullRefund();

        $this->assertNotNull($actual->fullRefund);
        $this->assertNull($actual->proratedRefund);
        $this->assertNull($actual->itemBasedRefund);
    }

    /** @test */
    public function prorated_refund(): void
    {
        $actual = RevocationContext::proratedRefund();

        $this->assertNotNull($actual->proratedRefund);
        $this->assertNull($actual->fullRefund);
        $this->assertNull($actual->itemBasedRefund);
    }

    /** @test */
    public function item_based_refund(): void
    {
        $productId = $this->faker->word();

        $actual = RevocationContext::itemBasedRefund($productId);

        $this->assertNotNull($actual->itemBasedRefund);
        $this->assertNull($actual->fullRefund);
        $this->assertNull($actual->proratedRefund);
        $this->assertEquals($productId, $actual->itemBasedRefund->productId);
    }
}
