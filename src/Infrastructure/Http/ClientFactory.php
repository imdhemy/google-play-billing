<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Infrastructure\Http;

use Google\Auth\ApplicationDefaultCredentials;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Auth\Middleware\AuthTokenMiddleware;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;

final class ClientFactory
{
    public static function create(?array $credentials = null): ClientInterface
    {
        $handlerStack = HandlerStack::create();
        $handlerStack->push(self::authMiddleware($credentials));
        $handlerStack->push(self::acceptJsonMiddleware());

        return new Client([
            'handler' => $handlerStack,
            'auth' => 'google_auth',
        ]);
    }

    /**
     * @return callable(callable): callable
     */
    private static function acceptJsonMiddleware(): callable
    {
        /** @var callable(callable): callable $middleware */
        $middleware = Middleware::mapRequest(function (RequestInterface $request): RequestInterface {
            return $request
                ->withHeader('Accept', 'application/json')
                ->withHeader('Content-Type', 'application/json');
        });

        return $middleware;
    }

    private static function authMiddleware(?array $credentials): AuthTokenMiddleware
    {
        $scope = ['https://www.googleapis.com/auth/androidpublisher'];

        if (null === $credentials) {
            return ApplicationDefaultCredentials::getMiddleware($scope);
        }

        return new AuthTokenMiddleware(
            new ServiceAccountCredentials($scope, $credentials)
        );
    }
}
