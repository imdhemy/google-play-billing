<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use DateTimeImmutable;
use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Order\Model\IntroductoryPriceDetails;
use Imdhemy\GooglePlay\Order\Model\OfferPhase;
use Imdhemy\GooglePlay\Order\Model\OfferPhaseDetails;
use Imdhemy\GooglePlay\Order\Model\SubscriptionDetails;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class SubscriptionDetailsTest extends TestCase
{
    #[Test]
    public function it_normalizes_every_documented_field(): void
    {
        $response = new Response(body: '{"basePlanId":"monthly","offerId":"intro","offerPhase":"INTRODUCTORY","offerPhaseDetails":{"introductoryPriceDetails":{}},"servicePeriodStartTime":"2026-01-02T03:04:05Z","servicePeriodEndTime":"2026-02-02T03:04:05Z"}');

        $subscriptionDetails = $this->normalizer->normalize(data: $response, type: SubscriptionDetails::class);

        $this->assertEquals(new SubscriptionDetails(
            basePlanId: 'monthly',
            offerId: 'intro',
            offerPhase: OfferPhase::INTRODUCTORY,
            offerPhaseDetails: new OfferPhaseDetails(introductoryPriceDetails: new IntroductoryPriceDetails()),
            servicePeriodStartTime: new DateTimeImmutable('2026-01-02T03:04:05Z'),
            servicePeriodEndTime: new DateTimeImmutable('2026-02-02T03:04:05Z'),
        ), $subscriptionDetails);
    }

    #[Test]
    public function it_leaves_fields_the_response_omits_as_null(): void
    {
        $response = new Response(body: '{}');

        $subscriptionDetails = $this->normalizer->normalize(data: $response, type: SubscriptionDetails::class);

        $this->assertEquals(new SubscriptionDetails(), $subscriptionDetails);
    }
}
