<?php


namespace Imdhemy\GooglePlay\Products;


use GuzzleHttp\Client;

class Product
{
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
        $this->productId = $packageName;
        $this->token = $token;
    }

    public function acknowledge()
    {
        $uri = "https://androidpublisher.googleapis.com/androidpublisher/v3/applications/{$this->packageName}/purchases/products/{$this->productId}/tokens/{$this->token}:acknowledge";
        return $response = $this->client->post($uri);
    }

    public function get()
    {
        return $this->client->get('');
    }
}