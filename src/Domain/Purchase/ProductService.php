<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase;

use GuzzleHttp\Psr7\Request;
use Imdhemy\GooglePlay\Domain\SerializerInterface;
use Psr\Http\Client\ClientInterface;

final readonly class ProductService
{
    private const string ACKNOWLEDGE_ENDPOINT = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/{packageName}/purchases/products/{productId}/tokens/{token}:acknowledge';

    public function __construct(
        private ClientInterface $client,
        private SerializerInterface $serializer,
    ) {
    }

    public function acknowledge(
        string $packageName,
        string $productId,
        string $token,
        string $developerPayload = '',
    ): void {
        $uri = str_replace(
            search: ['{packageName}', '{productId}', '{token}'],
            replace: [$packageName, $productId, $token],
            subject: self::ACKNOWLEDGE_ENDPOINT
        );

        $body = '' === $developerPayload ? '{}'
            : $this->serializer->serialize(data: ['developerPayload' => $developerPayload]);

        $request = new Request(
            method: 'POST',
            uri: $uri,
            headers: [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            body: $body,
        );

        $this->client->sendRequest($request);
    }
}
