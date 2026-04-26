<?php

declare(strict_types=1);

namespace Tests\AAA;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Client\RequestExceptionInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Tests\TestCase;

/**
 * @mixin TestCase
 */
trait ClientTrait
{
    protected function mockClient(
        array|ResponseInterface|RequestExceptionInterface $responses,
        array &$history = [],
    ): ClientInterface {
        $handlerStack = HandlerStack::create(new MockHandler(is_array($responses) ? $responses : [$responses]));
        $handlerStack->push(Middleware::history($history));

        return new Client([
            'handler' => $handlerStack,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    protected function assertClientSentRequest(array $history, Request $request): void
    {
        $requests = array_map(callback: static fn (array $entry) => $entry['request'], array: $history);
        $closest = $this->closestRequest($requests, $request);
        $this->assertNotNull($closest, 'No matching request was found in the history');
        $this->assertEquals($request->getMethod(), $closest->getMethod(), 'Request method does not match');
        $this->assertEquals((string)$request->getUri(), (string)$closest?->getUri(), 'Request URI does not match');
        $this->assertEquals((string)$request->getBody(), (string)$closest?->getBody(), 'Request body does not match');
        $expectedHeaders = $request->getHeaders();
        foreach ($expectedHeaders as $name => $values) {
            $this->assertArrayHasKey($name, $closest?->getHeaders(), "Header '$name' is missing in the request");
            $this->assertEquals($values, $closest?->getHeader($name), "Header '$name' does not match");
        }
    }

    protected function assertRequestEquals(RequestInterface $expected, RequestInterface $actual): void
    {
        $this->assertTrue($this->requestEquals($expected, $actual), 'The requests are not equal.');
    }

    protected function requestEquals(RequestInterface $expected, RequestInterface $actual): bool
    {
        return $expected->getMethod() === $actual->getMethod()
            && (string)$expected->getUri() === (string)$actual->getUri()
            && (string)$expected->getBody() === (string)$actual->getBody();
    }

    protected function closestRequest(array $haystack, Request $request): ?Request
    {
        $similarity = [];
        foreach ($haystack as $entry) {
            if ($this->requestEquals($request, $entry)) {
                return $entry;
            }
            $similarity[] = [
                'request' => $entry,
                'similarity' => $this->calculateSimilarity($request, $entry),
            ];
        }

        usort($similarity, static fn ($a, $b) => $b['similarity'] <=> $a['similarity']);

        return $similarity[0]['similarity'] > 0 ? $similarity[0]['request'] : null;
    }

    private function calculateSimilarity(Request $request, Request $actual): int
    {
        $similarity = 0;
        $similarity += similar_text($request->getMethod(), $actual->getMethod());
        $similarity += similar_text((string)$request->getUri(), (string)$actual->getUri());
        $similarity += similar_text((string)$request->getBody(), (string)$actual->getBody());
        $similarity += similar_text(
            $this->serializer->serialize($request->getHeaders()),
            $this->serializer->serialize($actual->getHeaders())
        );

        return $similarity;
    }
}
