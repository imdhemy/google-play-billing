<?php

namespace Imdhemy\GooglePlay\Tests\Products;

use Imdhemy\GooglePlay\ClientFactory;
use Imdhemy\GooglePlay\Products\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    /**
     * @var Product
     */
    private $product;

    protected function setUp(): void
    {
        parent::setUp();
        $client = ClientFactory::create([ClientFactory::SCOPE_ANDROID_PUBLISHER]);
        $this->product = new Product(
            $client,
            'com.twigano.v2',
            'boost_profile',
            'pbehplldfhianpgebmleegak.AO-J1Ox7SK22iXuGeWyOVQ-iCokC4UNOqiVwObG4avOfGCovt7GbpA7ih9KdXr4yQTmQUOPQulMksyVmaTq3VR2-VlTss_Pyue6i6aFgBotxvf2oXyTFfww'
        );
    }

    /**
     * @test
     */
    public function testGet()
    {
        $response = $this->product->acknowledge();
        var_dump($response);
    }

    public function testAcknowledge()
    {
    }
}
