<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase\Product;

use GuzzleHttp\Psr7\Request;
use Imdhemy\GooglePlay\Domain\NormalizerInterface;
use Imdhemy\GooglePlay\Domain\SerializerInterface;
use Psr\Http\Client\ClientInterface;
use UnexpectedValueException;

final readonly class ProductService
{
    private const string ACKNOWLEDGE_ENDPOINT = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/{packageName}/purchases/products/{productId}/tokens/{token}:acknowledge';
    private const string CONSUME_ENDPOINT = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/{packageName}/purchases/products/{productId}/tokens/{token}:consume';
    private const string GET_ENDPOINT = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/{packageName}/purchases/products/{productId}/tokens/{token}';

    public function __construct(
        private ClientInterface $client,
        private NormalizerInterface $normalizer,
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

    public function consume(string $packageName, string $productId, string $token): void
    {
        $uri = str_replace(
            search: ['{packageName}', '{productId}', '{token}'],
            replace: [$packageName, $productId, $token],
            subject: self::CONSUME_ENDPOINT
        );

        $request = new Request(
            method: 'POST',
            uri: $uri,
            headers: [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        );

        $this->client->sendRequest($request);
    }

    public function get(string $packageName, string $productId, string $token): ProductPurchase
    {
        $data = $this->doGet($packageName, $productId, $token);

        return $this->normalizer->normalize(data: $data, type: ProductPurchase::class);
    }

    private function doGet(string $packageName, string $productId, string $token): array
    {
        $uri = str_replace(
            search: ['{packageName}', '{productId}', '{token}'],
            replace: [$packageName, $productId, $token],
            subject: self::GET_ENDPOINT
        );

        $request = new Request(
            method: 'GET',
            uri: $uri,
            headers: [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        );

        $response = $this->client->sendRequest($request);
        $data = \json_decode($response->getBody()->getContents(), true, 512, JSON_PARTIAL_OUTPUT_ON_ERROR);

        if (! is_array($data)) {
            throw new UnexpectedValueException('Expected response to be an array.');
        }

        return $data;
    }
}
