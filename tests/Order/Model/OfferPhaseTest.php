<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use Imdhemy\GooglePlay\Order\Model\OfferPhase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class OfferPhaseTest extends TestCase
{
    #[Test]
    public function it_normalizes_a_backing_value(): void
    {
        $value = $this->randomEnumValue(OfferPhase::class);

        $actual = $this->normalizer->normalize($value, OfferPhase::class);

        $this->assertInstanceOf(OfferPhase::class, $actual);
        $this->assertSame($value, $actual->value);
    }
}
