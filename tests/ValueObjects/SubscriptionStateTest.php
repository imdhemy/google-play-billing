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
        $value = $this->faker->randomElement([
            'SUBSCRIPTION_STATE_UNSPECIFIED',
            'SUBSCRIPTION_STATE_PENDING',
            'SUBSCRIPTION_STATE_ACTIVE',
            'SUBSCRIPTION_STATE_PAUSED',
            'SUBSCRIPTION_STATE_IN_GRACE_PERIOD',
            'SUBSCRIPTION_STATE_ON_HOLD',
            'SUBSCRIPTION_STATE_CANCELED',
            'SUBSCRIPTION_STATE_EXPIRED',
            'SUBSCRIPTION_STATE_PENDING_PURCHASE_CANCELED',
        ]);

        $actual = $this->normalizer->normalize($value, SubscriptionState::class);

        $this->assertInstanceOf(SubscriptionState::class, $actual);
        $this->assertSame($value, $actual->value);
    }
}
