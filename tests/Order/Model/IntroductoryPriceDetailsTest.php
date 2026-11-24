<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use Imdhemy\GooglePlay\Order\Model\IntroductoryPriceDetails;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class IntroductoryPriceDetailsTest extends TestCase
{
    #[Test]
    public function it_normalizes_an_empty_object(): void
    {
        $data = $this->faker->introductoryPriceDetailsPayload();

        $introductoryPriceDetails = $this->normalizer->normalize(data: $data, type: IntroductoryPriceDetails::class);

        $this->assertEquals(new IntroductoryPriceDetails(), $introductoryPriceDetails);
    }
}
