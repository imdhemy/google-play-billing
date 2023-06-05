<?php

namespace Imdhemy\GooglePlay\Products;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Imdhemy\GooglePlay\ValueObjects\EmptyResponse;

/**
 * Class ProductClient
 * This class is responsible for handling all requests related to products to the Google Play API.
 */
class ProductClient
{
    public const URI_GET = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/purchases/products/%s/tokens/%s';
    public const URI_ACKNOWLEDGE = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/purchases/products/%s/tokens/%s:acknowledge';

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var string
     */
    protected $packageName;

    /**
     * @var string
     */
    protected $productId;

    /**
     * @var string
     */
    protected $token;

    /**
     * Product constructor.
     */
    public function __construct(ClientInterface $client, string $packageName, string $productId, string $token)
    {
        $this->client = $client;
        $this->packageName = $packageName;
        $this->productId = $productId;
        $this->token = $token;
    }

    /**
     * @throws GuzzleException
     */
    public function get(): ProductPurchase
    {
        $uri = $this->getEndpoint(self::URI_GET);

        $response = $this->client->get($uri);
        $responseBody = json_decode((string)$response->getBody(), true);

        return ProductPurchase::fromArray($responseBody);
    }

    /**
     * @throws GuzzleException
     */
    public function acknowledge(string $developerPayload = null): EmptyResponse
    {
        $uri = $this->getEndpoint(self::URI_ACKNOWLEDGE);

        $options = [
            'form_params' => [
                'developerPayload' => $developerPayload,
            ],
        ];

        return new EmptyResponse($this->client->post($uri, $options));
    }

    private function getEndpoint(string $template): string
    {
        return sprintf($template, $this->packageName, $this->productId, $this->token);
    }
}
