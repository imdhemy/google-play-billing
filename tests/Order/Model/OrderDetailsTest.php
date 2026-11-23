<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Order\Model\OrderDetails;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class OrderDetailsTest extends TestCase
{
    #[Test]
    public function it_normalizes_every_documented_field(): void
    {
        $response = new Response(body: '{"taxInclusive":true}');

        $orderDetails = $this->normalizer->normalize(data: $response, type: OrderDetails::class);

        $this->assertEquals(new OrderDetails(taxInclusive: true), $orderDetails);
    }

    #[Test]
    public function it_leaves_fields_the_response_omits_as_null(): void
    {
        $response = new Response(body: '{}');

        $orderDetails = $this->normalizer->normalize(data: $response, type: OrderDetails::class);

        $this->assertEquals(new OrderDetails(), $orderDetails);
    }
}
