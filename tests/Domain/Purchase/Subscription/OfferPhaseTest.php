<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\Domain\Purchase\Subscription\OfferPhase;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\OfferPhase\OriginalOfferPhaseType;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class OfferPhaseTest extends TestCase
{
    #[Test]
    public function instantiate_proration_period_offer(): void
    {
        $actual = $this->normalizer->normalize(['prorationPeriod' => [
            'originalOfferPhaseType' => OriginalOfferPhaseType::INTRODUCTORY->value,
        ]], OfferPhase::class);

        $this->assertInstanceOf(OfferPhase::class, $actual);
        $this->assertNotNull($actual->prorationPeriod);
        $this->assertEquals(OriginalOfferPhaseType::INTRODUCTORY, $actual->prorationPeriod->originalOfferPhaseType);
        $this->assertNull($actual->freeTrial);
        $this->assertNull($actual->introductoryPrice);
        $this->assertNull($actual->basePrice);
    }

    #[Test]
    public function instantiate_free_trial_offer(): void
    {
        $actual = $this->normalizer->normalize(['freeTrial' => []], OfferPhase::class);

        $this->assertInstanceOf(OfferPhase::class, $actual);
        $this->assertNotNull($actual->freeTrial);
        $this->assertNull($actual->prorationPeriod);
        $this->assertNull($actual->introductoryPrice);
        $this->assertNull($actual->basePrice);
    }

    #[Test]
    public function instantiate_introductory_price_offer(): void
    {
        $actual = $this->normalizer->normalize(['introductoryPrice' => []], OfferPhase::class);

        $this->assertInstanceOf(OfferPhase::class, $actual);
        $this->assertNotNull($actual->introductoryPrice);
        $this->assertNull($actual->prorationPeriod);
        $this->assertNull($actual->freeTrial);
        $this->assertNull($actual->basePrice);
    }

    #[Test]
    public function instantiate_base_price_offer(): void
    {
        $actual = $this->normalizer->normalize(['basePrice' => []], OfferPhase::class);

        $this->assertInstanceOf(OfferPhase::class, $actual);
        $this->assertNotNull($actual->basePrice);
        $this->assertNull($actual->prorationPeriod);
        $this->assertNull($actual->freeTrial);
        $this->assertNull($actual->introductoryPrice);
    }
}
