<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use Imdhemy\GooglePlay\Order\Model\PartialRefundState;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class PartialRefundStateTest extends TestCase
{
    #[Test]
    public function it_normalizes_a_backing_value(): void
    {
        $value = $this->randomEnumValue(PartialRefundState::class);

        $actual = $this->normalizer->normalize($value, PartialRefundState::class);

        $this->assertInstanceOf(PartialRefundState::class, $actual);
        $this->assertSame($value, $actual->value);
    }
}
