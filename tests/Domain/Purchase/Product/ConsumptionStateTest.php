<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Product;

use Imdhemy\GooglePlay\Domain\Purchase\Product\ConsumptionState;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ConsumptionStateTest extends TestCase
{
    #[Test]
    public function instantiation(): void
    {
        $value = $this->randomEnumValue(ConsumptionState::class);

        $actual = $this->normalizer->normalize($value, ConsumptionState::class);

        $this->assertInstanceOf(ConsumptionState::class, $actual);
        $this->assertSame($value, $actual->value);
    }
}
