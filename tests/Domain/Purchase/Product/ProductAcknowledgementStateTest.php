<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Product;

use Imdhemy\GooglePlay\Domain\Purchase\Product\ProductAcknowledgementState;
use Tests\TestCase;

final class ProductAcknowledgementStateTest extends TestCase
{
    /** @test */
    public function instantiation(): void
    {
        $value = $this->randomEnumValue(ProductAcknowledgementState::class);

        $actual = $this->normalizer->normalize($value, ProductAcknowledgementState::class);

        $this->assertInstanceOf(ProductAcknowledgementState::class, $actual);
        $this->assertSame($value, $actual->value);
    }
}
