<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Order\ReviewRefund;

use GuzzleHttp\Psr7\Request;
use Imdhemy\GooglePlay\Domain\Serializer\SerializerInterface;
use Imdhemy\GooglePlay\Exception\UnexpectedResponseException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;

/**
 * Submits the developer's refund preference and purchase usage information for a pending refund request.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/orders/reviewrefund
 */
final readonly class ReviewRefundOrder
{
    private const string ENDPOINT = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/{packageName}/orders/{orderId}:reviewrefund';

    public function __construct(
        private ClientInterface $client,
        private SerializerInterface $serializer,
    ) {
    }

    /**
     * @throws UnexpectedResponseException When the API returns a non-success response
     * @throws ClientExceptionInterface    When the request cannot be sent
     */
    public function execute(ReviewRefundOrderRequest $reviewRefundOrderRequest): void
    {
        $uri = str_replace(
            search: ['{packageName}', '{orderId}'],
            replace: [$reviewRefundOrderRequest->packageName, $reviewRefundOrderRequest->orderId],
            subject: self::ENDPOINT
        );

        $request = new Request(
            method: 'POST',
            uri: $uri,
            body: $this->serializer->serialize(data: $reviewRefundOrderRequest),
        );
        $response = $this->client->sendRequest($request);

        UnexpectedResponseException::assertSuccessfulResponse(
            request: $request,
            response: $response,
            operation: 'orders.reviewrefund',
        );
    }
}
