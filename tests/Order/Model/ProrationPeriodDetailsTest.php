<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Order\Model\OfferPhase;
use Imdhemy\GooglePlay\Order\Model\ProrationPeriodDetails;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ProrationPeriodDetailsTest extends TestCase
{
    #[Test]
    public function it_normalizes_every_documented_field(): void
    {
        $response = new Response(body: '{"originalOfferPhase":"INTRODUCTORY"}');

        $prorationPeriodDetails = $this->normalizer->normalize(data: $response, type: ProrationPeriodDetails::class);

        $this->assertEquals(new ProrationPeriodDetails(originalOfferPhase: OfferPhase::INTRODUCTORY), $prorationPeriodDetails);
    }

    #[Test]
    public function it_leaves_fields_the_response_omits_as_null(): void
    {
        $response = new Response(body: '{}');

        $prorationPeriodDetails = $this->normalizer->normalize(data: $response, type: ProrationPeriodDetails::class);

        $this->assertEquals(new ProrationPeriodDetails(), $prorationPeriodDetails);
    }
}
