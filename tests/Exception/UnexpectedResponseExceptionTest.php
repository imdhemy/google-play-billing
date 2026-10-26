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
    #[DataProvider('provide_successful_status_codes')]
    public function assert_successful_response_accepts_2xx_statuses(int $statusCode): void
    {
        $request = new Request(method: 'GET', uri: 'https://example.test/resource');
        $response = new Response(status: $statusCode);

        UnexpectedResponseException::assertSuccessfulResponse($request, $response, 'example.resource.get');

        $this->expectNotToPerformAssertions();
    }

    #[Test]
    #[DataProvider('provide_unsuccessful_status_codes')]
    public function assert_successful_response_rejects_unsuccessful_statuses(int $statusCode): void
    {
        $request = new Request(method: 'GET', uri: 'https://example.test/resource');
        $response = new Response(status: $statusCode);
        $this->expectException(UnexpectedResponseException::class);

        UnexpectedResponseException::assertSuccessfulResponse($request, $response, 'example.resource.get');
    }

    #[Test]
    public function exception_preserves_http_context(): void
    {
        $request = new Request(method: 'GET', uri: 'https://example.test/resource');
        $response = new Response(status: 403);

        try {
            UnexpectedResponseException::assertSuccessfulResponse($request, $response, 'example.resource.get');
        } catch (UnexpectedResponseException $exception) {
            $this->assertSame($request, $exception->getRequest());
            $this->assertSame($response, $exception->getResponse());
            $this->assertSame('Unexpected response for example.resource.get: HTTP 403.', $exception->getMessage());

            return;
        }

        $this->fail('Expected an unsuccessful response to be rejected.');
    }

    public static function provide_successful_status_codes(): iterable
    {
        yield 'at 200' => [200];
        yield 'at 299' => [299];
    }

    public static function provide_unsuccessful_status_codes(): iterable
    {
        yield 'below 200' => [199];
        yield 'at 300' => [300];
        yield 'client error' => [403];
        yield 'server error' => [500];
    }
}
