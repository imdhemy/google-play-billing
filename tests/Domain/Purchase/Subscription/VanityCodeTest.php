<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\Domain\Purchase\Subscription\VanityCode;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class VanityCodeTest extends TestCase
{
    #[Test]
    public function instantiation(): void
    {
        $promotionCode = $this->faker->word();

        $actual = $this->normalizer->normalize(['promotionCode' => $promotionCode], VanityCode::class);

        $this->assertInstanceOf(VanityCode::class, $actual);
        $this->assertSame($promotionCode, $actual->promotionCode);
    }
}
