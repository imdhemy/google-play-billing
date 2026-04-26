<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Monetization\Infrastructure\ConvertRegionPrices;

use GuzzleHttp\Psr7\Request;
use Imdhemy\GooglePlay\Infrastructure\Transformer\Serializer;
use Imdhemy\GooglePlay\Monetization\Application\ConvertRegionPrices\ConvertRegionPricesQuery;
use Imdhemy\GooglePlay\Monetization\Application\ConvertRegionPrices\ConvertRegionPricesRequestFactoryInterface;
use Psr\Http\Message\RequestInterface;

final readonly class GooglePlayConvertRegionPricesRequestFactory implements ConvertRegionPricesRequestFactoryInterface
{
    private const string ENDPOINT = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/{packageName}/pricing:convertRegionPrices';

    public function __construct(private Serializer $serializer)
    {
    }

    public function create(ConvertRegionPricesQuery $query): RequestInterface
    {
        $uri = str_replace(
            search: '{packageName}',
            replace: $query->packageName,
            subject: self::ENDPOINT,
        );

        return new Request(
            method: 'POST',
            uri: $uri,
            body: $this->serializer->serialize(data: $query),
        );
    }
}
