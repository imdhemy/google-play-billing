<?php

namespace Imdhemy\GooglePlay\Tests\Products;

use GuzzleHttp\Exception\GuzzleException;
use Imdhemy\GooglePlay\ClientFactory;
use Imdhemy\GooglePlay\Products\Product;
use Imdhemy\GooglePlay\Products\ProductPurchase;
use Imdhemy\GooglePlay\Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * @var Product
     */
    private $product;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();
        $client = ClientFactory::create([ClientFactory::SCOPE_ANDROID_PUBLISHER]);
        $this->product = new Product(
            $client,
            'com.simpleclick.lifebox',
            'price_1iiecwkkjlge9hvdjee3f2nf',
            'golbkblippbhphiippecihjm.AO-J1OwI8CmhowKXY5NrJeLMrucZLpryCw9EDpPnN4NOC29xES--VHnb_n2b0WUA_sAH1yrcqf3QBEmgbOO6-bnAiphresT9JuSAYiqky2sWZg54dxt5LNI'
        );
    }

    /**
     * @test
     * @throws GuzzleException
     */
    public function test_get()
    {
        $this->product->get()->getPurchaseTime();
        $response = $this->product->get();
        $this->assertInstanceOf(ProductPurchase::class, $response);
    }

    /**
     * @test
     * @throws GuzzleException
     */
    public function test_acknowledge()
    {
        $this->product->acknowledge();
        $this->assertTrue($this->product->get()->getAcknowledgementState()->isAcknowledged());
    }
}
