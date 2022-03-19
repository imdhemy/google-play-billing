<?php

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\SubscriptionDeferralInfo;
use Tests\TestCase;

class SubscriptionDeferralInfoTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_be_converted_into_an_array()
    {
        $expectedTime = $this->faker->unixTime();
        $desiredTime = $this->faker->unixTime();

        $info = new SubscriptionDeferralInfo($expectedTime, $desiredTime);
        $expected = [
            SubscriptionDeferralInfo::EXPECTED_EXPIRY_TIME_MILLIS => $expectedTime,
            SubscriptionDeferralInfo::DESIRED_EXPIRY_TIME_MILLIS => $desiredTime,
        ];

        $this->assertEquals($expected, $info->toArray());
    }
}
