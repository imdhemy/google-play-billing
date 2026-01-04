<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\Domain\Purchase\Subscription\DeferredItemReplacement;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class DeferredItemReplacementTest extends TestCase
{
    #[Test]
    public function instantiation(): void
    {
        $productId = $this->faker->word();
        $input = ['productId' => $productId];

        $actual = $this->normalizer->normalize($input, DeferredItemReplacement::class);

        $this->assertInstanceOf(DeferredItemReplacement::class, $actual);
        $this->assertSame($productId, $actual->productId);
    }
}
