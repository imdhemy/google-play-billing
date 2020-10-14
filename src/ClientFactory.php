<?php


namespace Imdhemy\GooglePlay;

use Google\Auth\ApplicationDefaultCredentials;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

class ClientFactory
{
    public const SCOPE_ANDROID_PUBLISHER = 'https://www.googleapis.com/auth/androidpublisher';

    /**
     * @param array $scopes
     * @return Client
     */
    public static function create(array $scopes): Client
    {
        // TODO: handle configs
        $path = realpath(__DIR__ . '/../google-app-credentials.json');
        putenv(sprintf("GOOGLE_APPLICATION_CREDENTIALS=%s", $path));

        $middleware = ApplicationDefaultCredentials::getMiddleware($scopes);
        $stack = HandlerStack::create();
        $stack->push($middleware);

        return new Client([
            'handler' => $stack,
            'base_uri' => 'https://www.googleapis.com',
            'auth' => 'google_auth',
        ]);
    }
}
