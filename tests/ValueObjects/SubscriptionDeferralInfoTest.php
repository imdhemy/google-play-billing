<?php

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\SubscriptionDeferralInfo;
use Tests\TestCase;

class SubscriptionDeferralInfoTest extends TestCase
{
    /**
     * @test
     */
    public function instantiation()
    {
        $data = [
            'expectedExpiryTimeMillis' => (string)$this->faker->unixTime(),
            'desiredExpiryTimeMillis' => (string)$this->faker->unixTime(),
        ];

        $actual = $this->normalizer->normalize($data, SubscriptionDeferralInfo::class);

        $this->assertSame($data['expectedExpiryTimeMillis'], $actual->getExpectedExpiryTimeMillis());
        $this->assertSame($data['desiredExpiryTimeMillis'], $actual->getDesiredExpiryTimeMillis());
    }
}
