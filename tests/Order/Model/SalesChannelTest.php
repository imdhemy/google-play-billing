<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use Imdhemy\GooglePlay\Order\Model\SalesChannel;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class SalesChannelTest extends TestCase
{
    #[Test]
    public function it_normalizes_a_backing_value(): void
    {
        $value = $this->randomEnumValue(SalesChannel::class);

        $actual = $this->normalizer->normalize($value, SalesChannel::class);

        $this->assertInstanceOf(SalesChannel::class, $actual);
        $this->assertSame($value, $actual->value);
    }
}
