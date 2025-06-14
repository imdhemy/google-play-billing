<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\ConsumptionState;
use Tests\TestCase;

final class ConsumptionStateTest extends TestCase
{
    /** @test */
    public function instantiation(): void
    {
        $value = $this->randomEnumValue(ConsumptionState::class);

        $actual = $this->normalizer->normalize($value, ConsumptionState::class);

        $this->assertInstanceOf(ConsumptionState::class, $actual);
        $this->assertSame($value, $actual->value);
    }
}
