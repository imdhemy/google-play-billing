<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\Domain\Purchase\Subscription\OfferDetails;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class OfferDetailsTest extends TestCase
{
    #[Test]
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

    #[Test]
    public function instantiation_with_required_fields(): void
    {
        $data = ['basePlanId' => $this->faker->word()];

        $actual = $this->normalizer->normalize($data, OfferDetails::class);

        $this->assertInstanceOf(OfferDetails::class, $actual);
        $this->assertSame($data['basePlanId'], $actual->basePlanId);
        $this->assertNull($actual->offerTags);
        $this->assertNull($actual->offerId);
    }
}
