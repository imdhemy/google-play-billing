<?php

namespace Tests\ValueObjects;

use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\ValueObjects\V1\EmptyResponse;
use PHPUnit\Framework\TestCase;

class EmptyResponseTest extends TestCase
{
    /**
     * @test
     */
    public function get_response()
    {
        $originalResponse = new Response();
        $response = new EmptyResponse($originalResponse);
        $this->assertSame($originalResponse, $response->getResponse());
    }
}
