<?php

namespace Imdhemy\GooglePlay\ValueObjects;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

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
    public function __construct(ResponseInterface $response)
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
