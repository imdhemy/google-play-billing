<?php

declare(strict_types=1);

namespace Tests\Order\Refund;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Exception\UnexpectedResponseException;
use Imdhemy\GooglePlay\Order\Refund\RefundOrder;
use Imdhemy\GooglePlay\Order\Refund\RefundOrderRequest;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class RefundOrderTest extends TestCase
{
    #[Test]
    public function execute_refunds_the_order(): void
    {
        $history = [];
        $client = $this->mockClient([new Response()], $history);
        $sut = new RefundOrder(client: $client);

        $sut->execute(new RefundOrderRequest(packageName: 'com.example.app', orderId: 'GPA.1234-5678-9012-34567'));

        $this->assertClientSentRequest(
            history: $history,
            request: new Request(
                method: 'POST',
                uri: 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/com.example.app/orders/GPA.1234-5678-9012-34567:refund',
                headers: [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
            ),
        );
        $this->assertSame('', $history[0]['request']->getUri()->getQuery());
        $this->assertSame('', (string)$history[0]['request']->getBody());
    }

    #[Test]
    public function execute_revokes_the_order_when_requested(): void
    {
        $history = [];
        $client = $this->mockClient([new Response()], $history);
        $sut = new RefundOrder(client: $client);

        $sut->execute(new RefundOrderRequest(packageName: 'com.example.app', orderId: 'GPA.1234-5678-9012-34567', revoke: true));

        $this->assertClientSentRequest(
            history: $history,
            request: new Request(
                method: 'POST',
                uri: 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/com.example.app/orders/GPA.1234-5678-9012-34567:refund?revoke=true',
            ),
        );
        $this->assertSame('', (string)$history[0]['request']->getBody());
    }

    #[Test]
    public function execute_throws_an_unexpected_response_exception_for_an_unsuccessful_response(): void
    {
        $errorBody = '{"error":{"code":400,"message":"The order is not refundable.","status":"FAILED_PRECONDITION"}}';
        $client = $this->mockClient(new Response(400, ['Content-Type' => 'application/json'], $errorBody));
        $sut = new RefundOrder(client: $client);

        try {
            $sut->execute(new RefundOrderRequest(packageName: 'com.example.app', orderId: 'GPA.1234-5678-9012-34567'));
            $this->fail('Expected an UnexpectedResponseException.');
        } catch (UnexpectedResponseException $exception) {
            $this->assertSame('Unexpected response for orders.refund: HTTP 400.', $exception->getMessage());
            $this->assertSame($errorBody, (string)$exception->getResponse()->getBody());
        }
    }
}
