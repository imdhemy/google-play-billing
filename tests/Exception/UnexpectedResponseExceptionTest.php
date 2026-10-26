<?php

declare(strict_types=1);

namespace Tests\Exception;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class UnexpectedResponseExceptionTest extends TestCase
{
    #[Test]
    public function assert_successful_response_accepts_2xx_statuses(): void
    {
        $request = new Request(method: 'GET', uri: 'https://example.test/resource');

        foreach ([200, 299] as $statusCode) {
            $response = new Response(status: $statusCode);

            UnexpectedResponseException::assertSuccessfulResponse(
                $request,
                $response,
                'example.resource.get',
            );

            $this->assertSame($statusCode, $response->getStatusCode());
        }
    }

    #[Test]
    #[DataProvider('unsuccessfulStatusCodes')]
    public function assert_successful_response_throws_and_preserves_http_context(int $statusCode): void
    {
        $request = new Request(method: 'GET', uri: 'https://example.test/resource');
        $body = '{"error":"Permission denied"}';
        $response = new Response(
            status: $statusCode,
            headers: ['Content-Type' => 'application/json'],
            body: $body,
        );

        try {
            UnexpectedResponseException::assertSuccessfulResponse(
                $request,
                $response,
                'example.resource.get',
            );

            $this->fail('Expected an unsuccessful response to be rejected.');
        } catch (UnexpectedResponseException $exception) {
            $this->assertSame($request, $exception->getRequest());
            $this->assertSame($response, $exception->getResponse());
            $this->assertSame($statusCode, $exception->getCode());
            $this->assertSame($statusCode, $exception->getResponse()->getStatusCode());
            $this->assertSame($body, (string)$exception->getResponse()->getBody());
            $this->assertStringContainsString('example.resource.get', $exception->getMessage());
        }
    }

    public static function unsuccessfulStatusCodes(): iterable
    {
        yield 'below 200' => [199];
        yield 'client error' => [403];
        yield 'at 300' => [300];
    }
}
