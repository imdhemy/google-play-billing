<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Order\Get;

use GuzzleHttp\Psr7\Request;
use Imdhemy\GooglePlay\Domain\Serializer\NormalizerInterface;
use Imdhemy\GooglePlay\Exception\UnexpectedResponseException;
use Imdhemy\GooglePlay\Order\Model\Order;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;

/**
 * Gets order details for a single order.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/orders/get
 */
final readonly class GetOrder
{
    private const string ENDPOINT = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/{packageName}/orders/{orderId}';

    public function __construct(
        private ClientInterface $client,
        private NormalizerInterface $normalizer,
    ) {
    }

    /**
     * @throws UnexpectedResponseException When the API returns a non-success response
     * @throws ClientExceptionInterface    When the request cannot be sent
     */
    public function execute(GetOrderRequest $getOrderRequest): GetOrderResponse
    {
        $uri = str_replace(
            search: ['{packageName}', '{orderId}'],
            replace: [$getOrderRequest->packageName, $getOrderRequest->orderId],
            subject: self::ENDPOINT
        );

        $request = new Request(method: 'GET', uri: $uri);
        $response = $this->client->sendRequest($request);

        UnexpectedResponseException::assertSuccessfulResponse(
            request: $request,
            response: $response,
            operation: 'orders.get',
        );

        return new GetOrderResponse(
            order: $this->normalizer->normalize(data: $response, type: Order::class),
        );
    }
}
