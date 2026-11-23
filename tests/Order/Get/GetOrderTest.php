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
    public function it_sends_a_get_request_for_the_order(): void
    {
        $history = [];
        $client = $this->mockClient([new Response(body: '{}')], $history);
        $sut = new GetOrder(client: $client, normalizer: $this->normalizer);

        $sut->execute(new GetOrderRequest(packageName: 'com.example.app', orderId: 'GPA.1234-5678-9012-34567'));

        $this->assertClientSentRequest(
            history: $history,
            request: new Request(
                method: 'GET',
                uri: 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/com.example.app/orders/GPA.1234-5678-9012-34567',
            ),
        );
    }

    #[Test]
    public function it_returns_the_order_and_the_unmodified_response_body(): void
    {
        $body = $this->asset('order/order.json');
        $client = $this->mockClient(new Response(body: $body));
        $sut = new GetOrder(client: $client, normalizer: $this->normalizer);

        $response = $sut->execute(new GetOrderRequest(packageName: 'com.example.app', orderId: 'GPA.1234-5678-9012-34567'));

        $this->assertEquals(
            new GetOrderResponse(order: $this->normalizer->normalize(data: new Response(body: $body), type: Order::class), body: $body),
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
