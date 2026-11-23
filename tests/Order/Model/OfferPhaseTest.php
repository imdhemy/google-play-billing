<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Order\Model\OfferPhase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class OfferPhaseTest extends TestCase
{
    /**
     * @return iterable<string, array{string, OfferPhase}>
     */
    public static function documentedValues(): iterable
    {
        yield 'OFFER_PHASE_UNSPECIFIED' => ['OFFER_PHASE_UNSPECIFIED', OfferPhase::UNSPECIFIED];
        yield 'BASE' => ['BASE', OfferPhase::BASE];
        yield 'INTRODUCTORY' => ['INTRODUCTORY', OfferPhase::INTRODUCTORY];
        yield 'FREE_TRIAL' => ['FREE_TRIAL', OfferPhase::FREE_TRIAL];
    }

    #[Test]
    #[DataProvider('documentedValues')]
    public function it_normalizes_every_documented_value(string $value, OfferPhase $expected): void
    {
        $response = new Response(body: json_encode($value, JSON_THROW_ON_ERROR));

        $offerPhase = $this->normalizer->normalize(data: $response, type: OfferPhase::class);

        $this->assertSame($expected, $offerPhase);
    }
}
