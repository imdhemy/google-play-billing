<?php

namespace Imdhemy\GooglePlay;

use Exception;
use Google\Auth\ApplicationDefaultCredentials;
use Google\Auth\CredentialsLoader;
use Google\Auth\Middleware\AuthTokenMiddleware;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Client\RequestExceptionInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ClientFactory is responsible for creating an HTTP client for
 * different use cases.
 */
class ClientFactory
{
    public const SCOPE_ANDROID_PUBLISHER = 'https://www.googleapis.com/auth/androidpublisher';
    private const BASE_URI = 'https://www.googleapis.com';
    private const GOOGLE_AUTH = 'google_auth';

    /**
     * Creates a client using the specified scopes. This method requires the
     * `GOOGLE_APPLICATION_CREDENTIALS` environment variable to be set.
     * {@link https://cloud.google.com/docs/authentication/production}.
     *
     * @param array $scopes optional scopes @since 2.0.0
     */
    public static function create(array $scopes = [self::SCOPE_ANDROID_PUBLISHER]): ClientInterface
    {
        $middleware = ApplicationDefaultCredentials::getMiddleware($scopes);

        return self::createWithMiddleware($middleware);
    }

    /**
     * Instead of setting the `GOOGLE_APPLICATION_CREDENTIALS` environment variable
     * you can the json key contents as an associative array to create an instance of a client.
     *
     * @param array $scopes optional scopes @since 2.0.0
     *
     * @throws Exception
     */
    public static function createWithJsonKey(
        array $jsonKey,
        array $scopes = [self::SCOPE_ANDROID_PUBLISHER]
    ): ClientInterface {
        $credentials = CredentialsLoader::makeCredentials($scopes, $jsonKey);
        $middleware = new AuthTokenMiddleware($credentials);

        return self::createWithMiddleware($middleware);
    }

    /**
     * Creates a client using Auth token middleware.
     */
    public static function createWithMiddleware(AuthTokenMiddleware $middleware): ClientInterface
    {
        $stack = HandlerStack::create();
        $stack->push($middleware);

        return new Client([
            'handler' => $stack,
            'base_uri' => self::BASE_URI,
            'auth' => self::GOOGLE_AUTH,
        ]);
    }

    /**
     * Creates a client that returns the specified response.
     *
     * @psalm-suppress ReferenceConstraintViolation
     */
    public static function mock(ResponseInterface $responseMock, array &$transactions = []): ClientInterface
    {
        $mockHandler = new MockHandler([$responseMock]);
        $handlerStack = HandlerStack::create($mockHandler);
        $handlerStack->push(Middleware::history($transactions));

        return new Client(['handler' => $handlerStack]);
    }

    /**
     * Creates a client that returns the specified array of responses in queue order.
     *
     * @param array|ResponseInterface[]|RequestExceptionInterface[] $responseQueue
     *
     * @psalm-suppress ReferenceConstraintViolation
     */
    public static function mockQueue(array $responseQueue, array &$transactions = []): ClientInterface
    {
        $mockHandler = new MockHandler($responseQueue);
        $handlerStack = HandlerStack::create($mockHandler);
        $handlerStack->push(Middleware::history($transactions));

        return new Client(['handler' => $handlerStack]);
    }

    /**
     * Creates a client that returns the specified request exception.
     *
     * @psalm-suppress ReferenceConstraintViolation
     */
    public static function mockError(RequestExceptionInterface $error, array &$transactions = []): ClientInterface
    {
        $mockHandler = new MockHandler([$error]);
        $handlerStack = HandlerStack::create($mockHandler);
        $handlerStack->push(Middleware::history($transactions));

        return new Client(['handler' => $handlerStack]);
    }
}
