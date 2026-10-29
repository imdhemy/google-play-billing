<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Order\Refund;

use GuzzleHttp\Psr7\Request;
use Imdhemy\GooglePlay\Exception\UnexpectedResponseException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;

/**
 * Refunds a user's subscription or in-app purchase order.
 *
 * Orders older than 3 years cannot be refunded.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/orders/refund
 */
final readonly class RefundOrder
{
    private const string ENDPOINT = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/{packageName}/orders/{orderId}:refund';

    public function __construct(private ClientInterface $client)
    {
    }

    /**
     * @throws UnexpectedResponseException When the API returns a non-success response
     * @throws ClientExceptionInterface    When the request cannot be sent
     */
    public function execute(RefundOrderRequest $refundOrderRequest): void
    {
        $uri = str_replace(
            search: ['{packageName}', '{orderId}'],
            replace: [$refundOrderRequest->packageName, $refundOrderRequest->orderId],
            subject: self::ENDPOINT
        );

        if ($refundOrderRequest->revoke) {
            $uri .= '?'.http_build_query(['revoke' => 'true']);
        }

        $request = new Request(method: 'POST', uri: $uri);
        $response = $this->client->sendRequest($request);

        UnexpectedResponseException::assertSuccessfulResponse(
            request: $request,
            response: $response,
            operation: 'orders.refund',
        );
    }
}
