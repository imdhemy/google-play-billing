<?php

namespace Tests\ValueObjects;

use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\ValueObjects\EmptyResponse;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class EmptyResponseTest extends TestCase
{
    #[Test]
    public function get_response()
    {
        $originalResponse = new Response();

        $response = new EmptyResponse($originalResponse);

        $this->assertSame($originalResponse, $response->getResponse());
    }
}
