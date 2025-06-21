<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\Domain\Purchase\Subscription\TestPurchase;
use Tests\TestCase;

final class TestPurchaseTest extends TestCase
{
    /** @test */
    public function instantiation(): void
    {
        $actual = $this->normalizer->normalize([], TestPurchase::class);

        $this->assertInstanceOf(TestPurchase::class, $actual);
    }
}
