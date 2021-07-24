<?php


namespace Imdhemy\GooglePlay;

use Exception;
use Google\Auth\ApplicationDefaultCredentials;
use Google\Auth\CredentialsLoader;
use Google\Auth\Middleware\AuthTokenMiddleware;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

class ClientFactory
{
    public const SCOPE_ANDROID_PUBLISHER = 'https://www.googleapis.com/auth/androidpublisher';

    /**
     * @param array $scopes
     * @return Client
     */
    public static function create(array $scopes = [self::SCOPE_ANDROID_PUBLISHER]): Client
    {
        $middleware = ApplicationDefaultCredentials::getMiddleware($scopes);

        return self::createFromWithMiddleware($middleware);
    }

    /**
     * @param array $jsonKey
     * @param array $scopes
     * @return Client
     * @throws Exception
     */
    public static function createWithJsonKey(array $jsonKey, array $scopes = [self::SCOPE_ANDROID_PUBLISHER]): Client
    {
        $credentials = CredentialsLoader::makeCredentials($scopes, $jsonKey);
        $middleware = new AuthTokenMiddleware($credentials);

        return self::createFromWithMiddleware($middleware);
    }

    /**
     * @param AuthTokenMiddleware $middleware
     * @return Client
     */
    public static function createFromWithMiddleware(AuthTokenMiddleware $middleware): Client
    {
        $stack = HandlerStack::create();
        $stack->push($middleware);

        return new Client([
          'handler' => $stack,
          'base_uri' => 'https://www.googleapis.com',
          'auth' => 'google_auth',
        ]);
    }
}
