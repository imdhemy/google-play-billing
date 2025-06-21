<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Product;

use Imdhemy\GooglePlay\Domain\Purchase\Product\PurchaseState;
use Tests\TestCase;

final class PurchaseStateTest extends TestCase
{
    /** @test */
    public function instantiation(): void
    {
        $value = $this->randomEnumValue(PurchaseState::class);

        $actual = $this->normalizer->normalize($value, PurchaseState::class);

        $this->assertInstanceOf(PurchaseState::class, $actual);
        $this->assertSame($value, $actual->value);
    }
}
