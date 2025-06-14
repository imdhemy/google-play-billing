<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\ProductAcknowledgementState;
use Tests\TestCase;

final class ProductAcknowledgementStateTest extends TestCase
{
    /** @test */
    public function instantiation(): void
    {
        $value = $this->randomEnumValue(ProductAcknowledgementState::class);

        $actual = $this->normalizer->normalize($value, ProductAcknowledgementState::class);

        $this->assertSame($value, $actual->value);
    }
}
