<?php


namespace Imdhemy\GooglePlay\Products;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Product
{
    const URI_GET = "https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/purchases/products/%s/tokens/%s";
    const URI_ACKNOWLEDGE = "https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/purchases/products/%s/tokens/%s:acknowledge";

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
        $uri = sprintf(self::URI_GET, $this->packageName, $this->productId, $this->token);
        $response = $this->client->get($uri);
        $responseBody = json_decode($response->getBody(), true);

        return ProductPurchase::fromResponseBody($responseBody);
    }

    /**
     * @param string|null $developerPayload
     * @throws GuzzleException
     */
    public function acknowledge(?string $developerPayload = null): void
    {
        $uri = sprintf(self::URI_ACKNOWLEDGE, $this->packageName, $this->productId, $this->token);
        $options = [
            'form_params' => [
                'developerPayload' => $developerPayload,
            ],
        ];
        $this->client->post($uri, $options);
    }
}
