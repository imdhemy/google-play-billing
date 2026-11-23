<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Order\Model\IntroductoryPriceDetails;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class IntroductoryPriceDetailsTest extends TestCase
{
    #[Test]
    public function it_normalizes_an_empty_object(): void
    {
        $response = new Response(body: '{}');

        $introductoryPriceDetails = $this->normalizer->normalize(data: $response, type: IntroductoryPriceDetails::class);

        $this->assertEquals(new IntroductoryPriceDetails(), $introductoryPriceDetails);
    }
}
