<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Monetization\Infrastructure;

use GuzzleHttp\Psr7\Request;
use Imdhemy\GooglePlay\Infrastructure\Transformer\Serializer;
use Imdhemy\GooglePlay\Monetization\Application\ConvertRegionPrices\ConvertRegionPricesQuery;
use Imdhemy\GooglePlay\Monetization\Application\MonetizationRequestFactoryInterface;
use Psr\Http\Message\RequestInterface;

final readonly class GooglePlayMonetizationRequestFactory implements MonetizationRequestFactoryInterface
{
    private const string ENDPOINT_CONVERT_REGION_PRICES = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/{packageName}/pricing:convertRegionPrices';

    public function __construct(private Serializer $serializer)
    {
    }

    public function createConvertRegionPricesRequest(ConvertRegionPricesQuery $query): RequestInterface
    {
        $uri = str_replace(
            search: '{packageName}',
            replace: $query->packageName,
            subject: self::ENDPOINT_CONVERT_REGION_PRICES
        );

        return new Request(
            method: 'POST',
            uri: $uri,
            body: $this->serializer->serialize(data: $query),
        );
    }
}
