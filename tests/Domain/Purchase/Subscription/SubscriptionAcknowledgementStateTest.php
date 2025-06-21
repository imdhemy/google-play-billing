<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\Domain\Purchase\Subscription\SubscriptionAcknowledgementState;
use Tests\TestCase;

final class SubscriptionAcknowledgementStateTest extends TestCase
{
    /** @test */
    public function instantiation(): void
    {
        $value = $this->faker->randomElement([
            'ACKNOWLEDGEMENT_STATE_UNSPECIFIED',
            'ACKNOWLEDGEMENT_STATE_PENDING',
            'ACKNOWLEDGEMENT_STATE_ACKNOWLEDGED',
        ]);

        $actual = $this->normalizer->normalize($value, SubscriptionAcknowledgementState::class);

        $this->assertInstanceOf(SubscriptionAcknowledgementState::class, $actual);
        $this->assertSame($value, $actual->value);
    }
}
