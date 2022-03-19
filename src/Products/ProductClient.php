<?php

namespace Imdhemy\GooglePlay\Products;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Imdhemy\GooglePlay\ValueObjects\EmptyResponse;

/**
 * Class ProductClient
 * This class is responsible for handling all requests related to products to the Google Play API
 */
class ProductClient
{
    public const URI_GET = "https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/purchases/products/%s/tokens/%s";
    public const URI_ACKNOWLEDGE = "https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/purchases/products/%s/tokens/%s:acknowledge";

    /**
     * @var Client
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
     * @param Client $client
     * @param string $packageName
     * @param string $productId
     * @param string $token
     */
    public function __construct(Client $client, string $packageName, string $productId, string $token)
    {
        $this->client = $client;
        $this->packageName = $packageName;
        $this->productId = $productId;
        $this->token = $token;
    }

    /**
     * @return ProductPurchase
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
     * @param string|null $developerPayload
     * @return EmptyResponse
     * @throws GuzzleException
     */
    public function acknowledge(?string $developerPayload = null): EmptyResponse
    {
        $uri = $this->getEndpoint(self::URI_ACKNOWLEDGE);

        $options = [
            'form_params' => [
                'developerPayload' => $developerPayload,
            ],
        ];

        return new EmptyResponse($this->client->post($uri, $options));
    }

    /**
     * @param string $template
     * @return string
     */
    private function getEndpoint(string $template): string
    {
        return sprintf($template, $this->packageName, $this->productId, $this->token);
    }
}
