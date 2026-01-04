<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Monetization\Application;

use GuzzleHttp\Psr7\Request;
use Imdhemy\GooglePlay\Domain\Serializer\NormalizerInterface;
use Imdhemy\GooglePlay\Domain\Serializer\SerializerInterface;
use Imdhemy\GooglePlay\Monetization\Domain\ConvertedPrices;
use Imdhemy\GooglePlay\ValueObjects\Money;
use Psr\Http\Client\ClientInterface;

final readonly class ConvertRegionPrices
{
    private const string ENDPOINT = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/{packageName}/pricing:convertRegionPrices';

    public function __construct(
        private ClientInterface $client,
        private SerializerInterface $serializer,
        private NormalizerInterface $normalizer,
    ) {
    }

    public function execute(
        string $packageName,
        Money $price,
    ): ConvertedPrices {
        $uri = str_replace(
            search: '{packageName}',
            replace: $packageName,
            subject: self::ENDPOINT
        );

        $body = $this->serializer->serialize(data: [
            'price' => $price,
        ]);

        $request = new Request(
            method: 'POST',
            uri: $uri,
            headers: [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            body: $body,
        );

        $response = $this->client->sendRequest($request);
        $payload = json_decode((string)$response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        return $this->normalizer->normalize(
            data: $payload,
            type: ConvertedPrices::class
        );
    }
}
