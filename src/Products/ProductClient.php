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
    public const URI_CONSUME = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/purchases/products/%s/tokens/%s:consume';

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
        $uri = $this->endpoint(self::URI_GET);

        $response = $this->client->get($uri);
        $responseBody = json_decode((string)$response->getBody(), true);

        return ProductPurchase::fromArray($responseBody);
    }

    /**
     * @throws GuzzleException
     */
    public function acknowledge(string $developerPayload = null): EmptyResponse
    {
        $uri = $this->endpoint(self::URI_ACKNOWLEDGE);

        $options = [
            'form_params' => [
                'developerPayload' => $developerPayload,
            ],
        ];

        return new EmptyResponse($this->client->post($uri, $options));
    }

    /**
     * @throws GuzzleException
     */
    public function consume(): EmptyResponse
    {
        $uri = $this->endpoint(self::URI_CONSUME);

        $options = [];

        return new EmptyResponse($this->client->post($uri, $options));
    }

    private function endpoint(string $template): string
    {
        return sprintf($template, $this->packageName, $this->productId, $this->token);
    }
}
