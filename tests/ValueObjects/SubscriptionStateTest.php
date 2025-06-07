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
        $value = $this->faker->randomElement(
            array_map(fn($c) => $c->value, SubscriptionState::cases())
        );

        $actual = $this->normalizer->normalize($value, SubscriptionState::class);

        $this->assertInstanceOf(SubscriptionState::class, $actual);
        $this->assertSame($value, $actual->value);
    }
}
