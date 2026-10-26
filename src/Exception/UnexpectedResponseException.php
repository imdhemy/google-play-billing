<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Exception;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

final class UnexpectedResponseException extends RuntimeException
{
    private function __construct(
        private RequestInterface $request,
        private ResponseInterface $response,
        string $operation,
    ) {
        $statusCode = $response->getStatusCode();

        parent::__construct(
            message: sprintf('Unexpected response for %s: HTTP %d.', $operation, $statusCode),
            code: $statusCode,
        );
    }

    public static function assertSuccessfulResponse(
        RequestInterface $request,
        ResponseInterface $response,
        string $operation,
    ): void {
        $statusCode = $response->getStatusCode();

        if ($statusCode >= 200 && $statusCode < 300) {
            return;
        }

        throw new self(request: $request, response: $response, operation: $operation);
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
