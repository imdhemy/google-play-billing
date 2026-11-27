<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use Imdhemy\GooglePlay\Order\Model\RefundReason;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class RefundReasonTest extends TestCase
{
    #[Test]
    public function it_normalizes_a_backing_value(): void
    {
        $value = $this->randomEnumValue(RefundReason::class);

        $actual = $this->normalizer->normalize($value, RefundReason::class);

        $this->assertInstanceOf(RefundReason::class, $actual);
        $this->assertSame($value, $actual->value);
    }
}
