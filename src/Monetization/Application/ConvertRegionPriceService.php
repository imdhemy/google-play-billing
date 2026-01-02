<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Monetization\Application;

use GuzzleHttp\Psr7\Request;
use Imdhemy\GooglePlay\Domain\Serializer\SerializerInterface;
use Imdhemy\GooglePlay\ValueObjects\Money;
use Psr\Http\Client\ClientInterface;

class ConvertRegionPriceService
{
    private const string ENDPOINT = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/{packageName}/pricing:convertRegionPrices';

    public function __construct(
        private ClientInterface $client,
        private SerializerInterface $serializer,
    ) {
    }

    public function execute(
        string $packageName,
        Money $price,
    ): void {
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

        $this->client->sendRequest($request);
    }
}
