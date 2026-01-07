<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Monetization\Application;

use GuzzleHttp\Psr7\Request;
use Imdhemy\GooglePlay\Domain\Serializer\NormalizerInterface;
use Imdhemy\GooglePlay\Domain\Serializer\SerializerInterface;
use Imdhemy\GooglePlay\Monetization\Domain\ConvertedPrices;
use Imdhemy\GooglePlay\Monetization\Domain\Exceptions\ConvertRegionPricesException;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
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

    /**
     * Convert region prices into different regions.
     *
     * @throws ConvertRegionPricesException
     */
    public function execute(
        ConvertRegionPricesPayload $regionPrice,
    ): ConvertedPrices {
        $uri = str_replace(
            search: '{packageName}',
            replace: $regionPrice->packageName,
            subject: self::ENDPOINT
        );

        $body = $this->serializer->serialize(data: [
            'price' => $regionPrice->price,
        ]);

        $request = new Request(
            method: 'POST',
            uri: $uri,
            body: $body,
        );

        try {
            $response = $this->client->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw ConvertRegionPricesException::fromClient($e);
        }

        try {
            /** @var array<string, mixed> $body */
            $body = json_decode((string)$response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw ConvertRegionPricesException::make($e->getMessage());
        }

        return $this->normalizer->normalize(
            data: $body,
            type: ConvertedPrices::class
        );
    }
}
