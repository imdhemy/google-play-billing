<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\SubscriptionState;
use Tests\TestCase;

final class SubscriptionStateTest extends TestCase
{
    /** @test */
    public function instantiation(): void
    {
        $value = $this->randomEnumValue(SubscriptionState::class);

        $actual = $this->normalizer->normalize($value, SubscriptionState::class);

        $this->assertInstanceOf(SubscriptionState::class, $actual);
        $this->assertSame($value, $actual->value);
    }
}
