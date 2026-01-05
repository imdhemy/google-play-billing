<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\Domain\Purchase\Subscription\PrepaidPlan;
use Imdhemy\GooglePlay\ValueObjects\Time;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class PrepaidPlanTest extends TestCase
{
    #[Test]
    public function can_instantiate_with_allow_extend_after_time(): void
    {
        $allowExtendAfterTime = '2014-10-02T15:01:23Z';
        $input = [
            'allowExtendAfterTime' => $allowExtendAfterTime,
        ];

        $actual = $this->normalizer->normalize($input, PrepaidPlan::class);

        $this->assertInstanceOf(PrepaidPlan::class, $actual);
        $this->assertInstanceOf(Time::class, $actual->allowExtendAfterTime);
        $this->assertSame($allowExtendAfterTime, $actual->allowExtendAfterTime->originalValue);
    }

    #[Test]
    public function can_instantiate_without_allow_extend_after_time(): void
    {
        $input = [];

        $actual = $this->normalizer->normalize($input, PrepaidPlan::class);

        $this->assertInstanceOf(PrepaidPlan::class, $actual);
        $this->assertNull($actual->allowExtendAfterTime);
    }
}
