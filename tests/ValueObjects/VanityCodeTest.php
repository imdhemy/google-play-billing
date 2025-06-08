<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\VanityCode;
use Tests\TestCase;

final class VanityCodeTest extends TestCase
{
    /** @test */
    public function instantiation(): void
    {
        $promotionCode = $this->faker->word();

        $actual = $this->normalizer->normalize(['promotionCode' => $promotionCode], VanityCode::class);

        $this->assertInstanceOf(VanityCode::class, $actual);
        $this->assertSame($promotionCode, $actual->promotionCode);
    }
}
