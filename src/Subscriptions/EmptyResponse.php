<?php

namespace Imdhemy\GooglePlay\Subscriptions;

use GuzzleHttp\Psr7\Response;

/**
 * Empty response class
 */
final class EmptyResponse
{
    /**
     * @var Response
     */
    private $response;

    /**
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }
}
