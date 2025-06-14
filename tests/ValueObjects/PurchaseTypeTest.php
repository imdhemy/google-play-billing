<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\PurchaseState;
use Imdhemy\GooglePlay\ValueObjects\PurchaseType;
use Tests\TestCase;

final class PurchaseTypeTest extends TestCase
{
    /** @test */
    public function instantiation(): void
    {
        $value = $this->randomEnumValue(PurchaseState::class);

        $actual = $this->normalizer->normalize($value, PurchaseType::class);

        $this->assertSame($value, $actual->value);
    }
}
