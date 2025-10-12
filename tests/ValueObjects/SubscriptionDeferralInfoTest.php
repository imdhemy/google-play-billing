<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\SubscriptionDeferralInfo;
use Tests\TestCase;

final class SubscriptionDeferralInfoTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_be_converted_into_an_array(): void
    {
        $expectedTime = (string)$this->faker->unixTime();
        $desiredTime = (string)$this->faker->unixTime();

        $info = new SubscriptionDeferralInfo($expectedTime, $desiredTime);
        $expected = [
            SubscriptionDeferralInfo::EXPECTED_EXPIRY_TIME_MILLIS => $expectedTime,
            SubscriptionDeferralInfo::DESIRED_EXPIRY_TIME_MILLIS => $desiredTime,
        ];

        $this->assertEquals($expected, $info->toArray());
    }
}
