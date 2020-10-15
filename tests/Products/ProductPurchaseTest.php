<?php

namespace Imdhemy\GooglePlay\Tests\Products;

use Faker\Factory;
use Imdhemy\GooglePlay\Products\ProductPurchase;
use PHPUnit\Framework\TestCase;

class ProductPurchaseTest extends TestCase
{
    /**
     * @test
     */
    public function test_it_can_be_created_from_client_response_body()
    {
        $faker = Factory::create();
        $body = [
            'kind' => 'someKind',
            'purchaseTimeMillis' => $faker->unixTime,
            'purchaseState' => rand(0, 2),
            'consumptionState' => rand(0, 1),
            'developerPayload' => null,
            'orderId' => $faker->uuid,
            'purchaseType' => rand(0, 2),
            'acknowledgementState' => rand(0, 1),
            'purchaseToken' => $faker->uuid,
            'productId' => $faker->company,
            'quantity' => 1,
            'obfuscatedExternalAccountId' => null,
            'obfuscatedExternalProfileId' => null,
            'regionCode' => $faker->countryCode,
        ];

        $this->assertInstanceOf(ProductPurchase::class, ProductPurchase::fromResponseBody($body));
    }
}
