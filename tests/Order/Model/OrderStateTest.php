<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use Imdhemy\GooglePlay\Order\Model\OrderState;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class OrderStateTest extends TestCase
{
    #[Test]
    public function it_normalizes_a_backing_value(): void
    {
        $value = $this->randomEnumValue(OrderState::class);

        $actual = $this->normalizer->normalize($value, OrderState::class);

        $this->assertInstanceOf(OrderState::class, $actual);
        $this->assertSame($value, $actual->value);
    }
}
