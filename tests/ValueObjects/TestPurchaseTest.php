<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\TestPurchase;
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
