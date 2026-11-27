<?php

declare(strict_types=1);

namespace Tests\Order\Get;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Exception\UnexpectedResponseException;
use Imdhemy\GooglePlay\Order\Get\GetOrder;
use Imdhemy\GooglePlay\Order\Get\GetOrderRequest;
use Imdhemy\GooglePlay\Order\Get\GetOrderResponse;
use Imdhemy\GooglePlay\Order\Model\Order;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class GetOrderTest extends TestCase
{
    #[Test]
    public function it_gets_the_order_and_keeps_the_unmodified_response_body(): void
    {
        $history = [];
        $client = $this->mockClient($this->faker->orderResponse(), $history);
        $sut = new GetOrder(client: $client, normalizer: $this->normalizer);

        $response = $sut->execute(new GetOrderRequest(packageName: 'com.example.app', orderId: 'GPA.1234-5678-9012-34567'));

        $this->assertClientSentRequest(
            history: $history,
            request: new Request(
                method: 'GET',
                uri: 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/com.example.app/orders/GPA.1234-5678-9012-34567',
            ),
        );
        $this->assertEquals(
            new GetOrderResponse(
                order: $this->normalizer->normalize(data: $this->faker->orderResponse(), type: Order::class),
                body: $this->faker->orderResponseBody(),
            ),
            $response,
        );
    }

    #[Test]
    public function it_throws_an_unexpected_response_exception_for_an_unsuccessful_response(): void
    {
        $errorBody = '{"error":{"code":404,"message":"Order not found.","status":"NOT_FOUND"}}';
        $client = $this->mockClient(new Response(404, ['Content-Type' => 'application/json'], $errorBody));
        $sut = new GetOrder(client: $client, normalizer: $this->normalizer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage('Unexpected response for orders.get: HTTP 404.');

        $sut->execute(new GetOrderRequest(packageName: 'com.example.app', orderId: 'GPA.1234-5678-9012-34567'));
    }
}
