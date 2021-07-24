<?php

namespace Imdhemy\GooglePlay\Tests;

use Exception;
use GuzzleHttp\Client;
use Imdhemy\GooglePlay\ClientFactory;

class ClientFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function test_it_creates_guzzle_http_client()
    {
        $scopes = [ClientFactory::SCOPE_ANDROID_PUBLISHER];
        $client = ClientFactory::create($scopes);
        $this->assertInstanceOf(Client::class, $client);
    }

    /**
     * @test
     */
    public function test_scopes_are_optional()
    {
        $this->assertInstanceOf(Client::class, ClientFactory::create());
    }

    /**
     * @test
     * @throws Exception
     */
    public function test_it_creates_guzzle_http_client_with_json_key_supplied_as_array()
    {
        $keyStream = file_get_contents(__DIR__ . '/assets/google-app-credentials.json');
        $jsonKey = json_decode($keyStream, true);
        $client = ClientFactory::createWithJsonKey($jsonKey);
        $this->assertInstanceOf(Client::class, $client);
    }
}
