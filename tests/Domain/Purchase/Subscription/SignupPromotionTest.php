<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\Domain\Purchase\Subscription\OneTimeCode;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\SignupPromotion;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\VanityCode;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class SignupPromotionTest extends TestCase
{
    #[test]
    public function can_instantiate_with_one_time_code(): void
    {
        $data = ['oneTimeCode' => []];

        $actual = $this->normalizer->normalize($data, SignupPromotion::class);

        $this->assertInstanceOf(SignupPromotion::class, $actual);
        $this->assertInstanceOf(OneTimeCode::class, $actual->oneTimeCode);
        $this->assertNull($actual->vanityCode);
    }

    #[test]
    public function can_instantiate_with_vanity_code(): void
    {
        $promotionCode = $this->faker->word();
        $input = ['vanityCode' => ['promotionCode' => $promotionCode]];

        $actual = $this->normalizer->normalize($input, SignupPromotion::class);

        $this->assertInstanceOf(SignupPromotion::class, $actual);
        $this->assertInstanceOf(VanityCode::class, $actual->vanityCode);
        $this->assertSame($promotionCode, $actual->vanityCode->promotionCode);
        $this->assertNull($actual->oneTimeCode);
    }
}
