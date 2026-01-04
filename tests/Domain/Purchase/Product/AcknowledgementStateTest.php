<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Product;

use Imdhemy\GooglePlay\Domain\Purchase\Product\AcknowledgementState;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class AcknowledgementStateTest extends TestCase
{
    #[test]
    public function instantiation(): void
    {
        $value = $this->randomEnumValue(AcknowledgementState::class);

        $actual = $this->normalizer->normalize($value, AcknowledgementState::class);

        $this->assertInstanceOf(AcknowledgementState::class, $actual);
        $this->assertSame($value, $actual->value);
    }
}
