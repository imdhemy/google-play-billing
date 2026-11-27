<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use Imdhemy\GooglePlay\Order\Model\PointsDetails;
use Imdhemy\GooglePlay\ValueObjects\Money;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class PointsDetailsTest extends TestCase
{
    #[Test]
    public function it_normalizes_every_documented_field(): void
    {
        $data = $this->faker->pointsDetailsPayload();

        $pointsDetails = $this->normalizer->normalize(data: $data, type: PointsDetails::class);

        $this->assertEquals(new PointsDetails(
            pointsOfferId: 'points-offer',
            pointsSpent: '9007199254740993',
            pointsDiscountRateMicros: '250000',
            pointsCouponValue: new Money('EUR', '2', 0),
        ), $pointsDetails);
    }

    #[Test]
    public function it_leaves_fields_the_response_omits_as_null(): void
    {
        $pointsDetails = $this->normalizer->normalize(data: [], type: PointsDetails::class);

        $this->assertEquals(new PointsDetails(), $pointsDetails);
    }
}
