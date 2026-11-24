<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use DateTimeImmutable;
use Imdhemy\GooglePlay\Order\Model\FreeTrialDetails;
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
        $data = $this->faker->subscriptionDetailsPayload();

        $subscriptionDetails = $this->normalizer->normalize(data: $data, type: SubscriptionDetails::class);

        $this->assertEquals(new SubscriptionDetails(
            basePlanId: 'monthly',
            offerId: 'trial',
            offerPhase: OfferPhase::FREE_TRIAL,
            offerPhaseDetails: new OfferPhaseDetails(freeTrialDetails: new FreeTrialDetails()),
            servicePeriodStartTime: new DateTimeImmutable('2026-01-02T03:04:05Z'),
            servicePeriodEndTime: new DateTimeImmutable('2026-02-02T03:04:05Z'),
        ), $subscriptionDetails);
    }

    #[Test]
    public function it_leaves_fields_the_response_omits_as_null(): void
    {
        $subscriptionDetails = $this->normalizer->normalize(data: [], type: SubscriptionDetails::class);

        $this->assertEquals(new SubscriptionDetails(), $subscriptionDetails);
    }
}
