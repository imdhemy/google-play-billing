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

        return new Client(['handler' => $handlerStack]);
    }

    protected function assertClientSentRequest(array $history, Request $request): void
    {
        $requests = array_map(callback: static fn (array $entry) => $entry['request'], array: $history);
        $found = $this->findInArray(
            array: $requests,
            callback: fn (Request $actual) => $this->requestEquals(expected: $request, actual: $actual)
        );
        $this->assertNotNull($found, 'Expected request not found in history.');
    }

    protected function requestEquals(Request $expected, Request $actual): bool
    {
        return $expected->getMethod() === $actual->getMethod()
            && (string)$expected->getUri() === (string)$actual->getUri()
            && (string)$expected->getBody() === (string)$actual->getBody();
    }

    protected function findInArray(array $array, callable $callback): mixed
    {
        foreach ($array as $item) {
            if ($callback($item)) {
                return $item;
            }
        }

        return null;
    }
}
