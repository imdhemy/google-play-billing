<?php

namespace Tests\Products;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\ClientFactory;
use Imdhemy\GooglePlay\Products\ProductClient;
use Imdhemy\GooglePlay\Products\ProductPurchase;
use Imdhemy\GooglePlay\ValueObjects\EmptyResponse;
use Tests\TestCase;

/**
 * Class ProductClientTest
 */
class ProductClientTest extends TestCase
{
    /**
     * @var string
     */
    private $packageName;
    /**
     * @var string
     */
    private $productId;
    /**
     * @var string
     */
    private $token;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->packageName = 'com.some.thing';
        $this->productId = 'fake_id';
        $this->token = 'fake_token';
    }

    /**
     * @test
     * @throws GuzzleException
     */
    public function test_it_can_send_get_request()
    {
        $response = new Response(200, [], '[]');
        $transactions = [];

        $client = ClientFactory::mock($response, $transactions);

        $product = new ProductClient(
            $client,
            $this->packageName,
            $this->productId,
            $this->token
        );

        $this->assertInstanceOf(ProductPurchase::class, $product->get());

        /** @var Request $request */
        $request = $transactions[0]['request'];
        $this->assertEquals($this->getEndpoint(ProductClient::URI_GET), (string)$request->getUri());
    }

    /**
     * @test
     * @throws GuzzleException
     */
    public function test_it_can_send_acknowledge_request()
    {
        $response = new Response(200, [], '[]');
        $transactions = [];

        $client = ClientFactory::mock($response, $transactions);

        $product = new ProductClient(
            $client,
            $this->packageName,
            $this->productId,
            $this->token
        );

        $this->assertInstanceOf(EmptyResponse::class, $product->acknowledge());

        /** @var Request $request */
        $request = $transactions[0]['request'];
        $this->assertEquals($this->getEndpoint(ProductClient::URI_ACKNOWLEDGE), (string)$request->getUri());
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
