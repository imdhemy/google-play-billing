<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Monetization\Application;

use Imdhemy\GooglePlay\Domain\Serializer\NormalizerInterface;
use Imdhemy\GooglePlay\Monetization\Domain\ConvertedPrices;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;

final readonly class ConvertRegionPrices
{
    public function __construct(
        private ClientInterface $client,
        private MonetizationRequestFactoryInterface $requestFactory,
        private NormalizerInterface $normalizer,
    ) {
    }

    /**
     * Convert region prices into different regions.
     *
     * @throws MonetizationException
     */
    public function execute(ConvertRegionPricesPayload $convertRegionPricesPayload): ConvertedPrices
    {
        $request = $this->requestFactory->create($convertRegionPricesPayload);

        try {
            $response = $this->client->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new MonetizationException(message: $e->getMessage(), previous: $e);
        }

        return $this->normalizer->normalize(data: $response, type: ConvertedPrices::class);
    }
}
