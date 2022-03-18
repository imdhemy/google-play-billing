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
     * @var ResponseInterface
     */
    private $response;

    /**
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @return Response
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
