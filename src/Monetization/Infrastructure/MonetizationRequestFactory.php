<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Monetization\Infrastructure;

use GuzzleHttp\Psr7\Request;
use Imdhemy\GooglePlay\Infrastructure\Transformer\Serializer;
use Imdhemy\GooglePlay\Monetization\Application\MonetizationRequestFactoryInterface;
use Psr\Http\Message\RequestInterface;

final class MonetizationRequestFactory implements MonetizationRequestFactoryInterface
{
    private const string ENDPOINT = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/{packageName}/pricing:convertRegionPrices';

    public function __construct(private Serializer $serializer)
    {
    }

    public function create(object $data): RequestInterface
    {
        $uri = str_replace(
            search: '{packageName}',
            replace: $data->packageName,
            subject: self::ENDPOINT
        );

        $body = $this->serializer->serialize(data: [
            'price' => $data->price,
        ]);

        return new Request(
            method: 'POST',
            uri: $uri,
            body: $body,
        );
    }
}
