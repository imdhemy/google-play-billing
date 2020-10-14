<?php

namespace Imdhemy\GooglePlay\Tests;

use GuzzleHttp\Client;
use Imdhemy\GooglePlay\ClientFactory;
use PHPUnit\Framework\TestCase;

class ClientFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function test_it_creates_guzzle_http_client()
    {
        $client = ClientFactory::create([ClientFactory::SCOPE_ANDROID_PUBLISHER]);
        $this->assertInstanceOf(Client::class, $client);
    }
}
