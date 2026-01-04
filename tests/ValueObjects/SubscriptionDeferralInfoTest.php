<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\SubscriptionDeferralInfo;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class SubscriptionDeferralInfoTest extends TestCase
{
    #[Test]
    public function it_can_be_converted_into_an_array(): void
    {
        $expectedTime = '1704067200000';
        $desiredTime = '1735689600000';
        $info = new SubscriptionDeferralInfo($expectedTime, $desiredTime);

        $actual = $info->toArray();

        $this->assertSame([
            SubscriptionDeferralInfo::EXPECTED_EXPIRY_TIME_MILLIS => $expectedTime,
            SubscriptionDeferralInfo::DESIRED_EXPIRY_TIME_MILLIS => $desiredTime,
        ], $actual);
    }
}
