<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Order\Model\PointsDetails;
use Imdhemy\GooglePlay\ValueObjects\Money;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class PointsDetailsTest extends TestCase
{
    #[Test]
    public function it_normalizes_every_documented_field(): void
    {
        $response = new Response(body: '{"pointsOfferId":"points-offer","pointsSpent":"9007199254740993","pointsDiscountRateMicros":"250000","pointsCouponValue":{"currencyCode":"EUR","units":"2","nanos":0}}');

        $pointsDetails = $this->normalizer->normalize(data: $response, type: PointsDetails::class);

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
        $response = new Response(body: '{}');

        $pointsDetails = $this->normalizer->normalize(data: $response, type: PointsDetails::class);

        $this->assertEquals(new PointsDetails(), $pointsDetails);
    }
}
