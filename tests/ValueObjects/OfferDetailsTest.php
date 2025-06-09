<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\OfferDetails;
use Tests\TestCase;

final class OfferDetailsTest extends TestCase
{
    /** @test */
    public function instantiation(): void
    {
        $offerTags = [$this->faker->word(), $this->faker->word()];
        $basePlanId = $this->faker->word();
        $offerId = $this->faker->word();
        $input = [
            'offerTags' => $offerTags,
            'basePlanId' => $basePlanId,
            'offerId' => $offerId,
        ];

        $actual = $this->normalizer->normalize($input, OfferDetails::class);

        $this->assertInstanceOf(OfferDetails::class, $actual);
        $this->assertSame($offerTags, $actual->offerTags);
        $this->assertSame($basePlanId, $actual->basePlanId);
        $this->assertSame($offerId, $actual->offerId);
    }
}
