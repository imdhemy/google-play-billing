<?php

namespace Imdhemy\GooglePlay\Tests;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
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

    /**
     * @test
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function test_client_response_can_be_mocked()
    {
        $statusCode = 200;
        $body = 'This is a mock!';
        $mock = new Response($statusCode, [], $body);

        $client = ClientFactory::mock($mock);
        $response = $client->request('GET', '/');

        $this->assertEquals($statusCode, $response->getStatusCode());
        $this->assertEquals($body, (string)$response->getBody());
    }

    /**
     * @test
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function test_a_queue_of_responses_can_be_mocked()
    {
        $mocks = [
          new Response(200, [], 'first'),
          new Response(201, [], 'second'),
        ];
        $client = ClientFactory::mockQueue($mocks);

        $firstResponse = $client->request('GET', '/');
        $this->assertEquals(200, $firstResponse->getStatusCode());
        $this->assertEquals('first', (string)$firstResponse->getBody());

        $secondResponse = $client->request('POST', '/');
        $this->assertEquals(201, $secondResponse->getStatusCode());
        $this->assertEquals('second', (string)$secondResponse->getBody());
    }

    /**
     * @test
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function test_it_can_mock_an_error_response()
    {
        $message = 'Something went wrong';

        $this->expectException(RequestException::class);
        $this->expectExceptionMessage($message);

        $error = new RequestException(
          $message,
          new Request('GET', '/admin'),
          new Response(403, [], 'Forbidden')
        );
        $client = ClientFactory::mockError($error);

        $client->request('GET', '/admin');
    }
}
