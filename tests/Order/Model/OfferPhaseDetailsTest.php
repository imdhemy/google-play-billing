<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use Imdhemy\GooglePlay\Order\Model\BaseDetails;
use Imdhemy\GooglePlay\Order\Model\FreeTrialDetails;
use Imdhemy\GooglePlay\Order\Model\IntroductoryPriceDetails;
use Imdhemy\GooglePlay\Order\Model\OfferPhase;
use Imdhemy\GooglePlay\Order\Model\OfferPhaseDetails;
use Imdhemy\GooglePlay\Order\Model\ProrationPeriodDetails;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class OfferPhaseDetailsTest extends TestCase
{
    #[Test]
    public function it_normalizes_free_trial_details(): void
    {
        $data = $this->faker->offerPhaseDetailsPayload('monthly001');

        $offerPhaseDetails = $this->normalizer->normalize(data: $data, type: OfferPhaseDetails::class);

        $this->assertEquals(new OfferPhaseDetails(freeTrialDetails: new FreeTrialDetails()), $offerPhaseDetails);
    }

    #[Test]
    public function it_normalizes_base_details(): void
    {
        $data = $this->faker->offerPhaseDetailsPayload('yearly001');

        $offerPhaseDetails = $this->normalizer->normalize(data: $data, type: OfferPhaseDetails::class);

        $this->assertEquals(new OfferPhaseDetails(baseDetails: new BaseDetails()), $offerPhaseDetails);
    }

    #[Test]
    public function it_normalizes_introductory_price_details(): void
    {
        $data = $this->faker->offerPhaseDetailsPayload('weekly001');

        $offerPhaseDetails = $this->normalizer->normalize(data: $data, type: OfferPhaseDetails::class);

        $this->assertEquals(new OfferPhaseDetails(introductoryPriceDetails: new IntroductoryPriceDetails()), $offerPhaseDetails);
    }

    #[Test]
    public function it_normalizes_proration_period_details(): void
    {
        $data = $this->faker->offerPhaseDetailsPayload('premium001');

        $offerPhaseDetails = $this->normalizer->normalize(data: $data, type: OfferPhaseDetails::class);

        $this->assertEquals(new OfferPhaseDetails(prorationPeriodDetails: new ProrationPeriodDetails(originalOfferPhase: OfferPhase::INTRODUCTORY)), $offerPhaseDetails);
    }

    #[Test]
    public function it_leaves_fields_the_response_omits_as_null(): void
    {
        $offerPhaseDetails = $this->normalizer->normalize(data: [], type: OfferPhaseDetails::class);

        $this->assertEquals(new OfferPhaseDetails(), $offerPhaseDetails);
    }
}
