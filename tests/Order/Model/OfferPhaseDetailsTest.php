<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use GuzzleHttp\Psr7\Response;
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
    public function it_normalizes_base_details(): void
    {
        $response = new Response(body: '{"baseDetails":{}}');

        $offerPhaseDetails = $this->normalizer->normalize(data: $response, type: OfferPhaseDetails::class);

        $this->assertEquals(new OfferPhaseDetails(baseDetails: new BaseDetails()), $offerPhaseDetails);
    }

    #[Test]
    public function it_normalizes_introductory_price_details(): void
    {
        $response = new Response(body: '{"introductoryPriceDetails":{}}');

        $offerPhaseDetails = $this->normalizer->normalize(data: $response, type: OfferPhaseDetails::class);

        $this->assertEquals(new OfferPhaseDetails(introductoryPriceDetails: new IntroductoryPriceDetails()), $offerPhaseDetails);
    }

    #[Test]
    public function it_normalizes_free_trial_details(): void
    {
        $response = new Response(body: '{"freeTrialDetails":{}}');

        $offerPhaseDetails = $this->normalizer->normalize(data: $response, type: OfferPhaseDetails::class);

        $this->assertEquals(new OfferPhaseDetails(freeTrialDetails: new FreeTrialDetails()), $offerPhaseDetails);
    }

    #[Test]
    public function it_normalizes_proration_period_details(): void
    {
        $response = new Response(body: '{"prorationPeriodDetails":{"originalOfferPhase":"BASE"}}');

        $offerPhaseDetails = $this->normalizer->normalize(data: $response, type: OfferPhaseDetails::class);

        $this->assertEquals(new OfferPhaseDetails(prorationPeriodDetails: new ProrationPeriodDetails(originalOfferPhase: OfferPhase::BASE)), $offerPhaseDetails);
    }

    #[Test]
    public function it_leaves_fields_the_response_omits_as_null(): void
    {
        $response = new Response(body: '{}');

        $offerPhaseDetails = $this->normalizer->normalize(data: $response, type: OfferPhaseDetails::class);

        $this->assertEquals(new OfferPhaseDetails(), $offerPhaseDetails);
    }
}
