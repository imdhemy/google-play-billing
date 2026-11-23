<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Order\Model\BuyerAddress;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class BuyerAddressTest extends TestCase
{
    #[Test]
    public function it_normalizes_every_documented_field(): void
    {
        $response = new Response(body: '{"buyerPostcode":"28001","buyerState":"Madrid","buyerCountry":"ES"}');

        $buyerAddress = $this->normalizer->normalize(data: $response, type: BuyerAddress::class);

        $this->assertEquals(new BuyerAddress(buyerPostcode: '28001', buyerState: 'Madrid', buyerCountry: 'ES'), $buyerAddress);
    }

    #[Test]
    public function it_leaves_fields_the_response_omits_as_null(): void
    {
        $response = new Response(body: '{}');

        $buyerAddress = $this->normalizer->normalize(data: $response, type: BuyerAddress::class);

        $this->assertEquals(new BuyerAddress(), $buyerAddress);
    }
}
