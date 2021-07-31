<?php

namespace Imdhemy\GooglePlay\Tests\Products;

use Exception;
use Faker\Factory;
use Imdhemy\GooglePlay\Products\ProductPurchase;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;

/**
 * Class ProductPurchaseTest
 * @package Imdhemy\GooglePlay\Tests\Products
 */
class ProductPurchaseTest extends TestCase
{
    /**
     * @test
     * @throws Exception
     */
    public function test_it_can_be_created_from_array()
    {
        $faker = Factory::create();
        $body = [
            'kind' => 'someKind',
            'purchaseTimeMillis' => $faker->unixTime,
            'purchaseState' => random_int(0, 2),
            'consumptionState' => random_int(0, 1),
            'developerPayload' => null,
            'orderId' => $faker->uuid,
            'purchaseType' => random_int(0, 2),
            'acknowledgementState' => random_int(0, 1),
            'purchaseToken' => $faker->uuid,
            'productId' => $faker->company,
            'quantity' => 1,
            'obfuscatedExternalAccountId' => null,
            'obfuscatedExternalProfileId' => null,
            'regionCode' => $faker->countryCode,
        ];

        $this->assertInstanceOf(ProductPurchase::class, ProductPurchase::fromArray($body));
    }

    /**
     * @test
     */
    public function test_all_props_are_optional()
    {
        $productPurchase = ProductPurchase::fromArray([]);
        $this->assertInstanceOf(ProductPurchase::class, $productPurchase);

        $reflectionClass = new ReflectionClass($productPurchase);
        $publicMethods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);
        $staticMethods = $reflectionClass->getMethods(ReflectionMethod::IS_STATIC);
        $methods = array_diff($publicMethods, $staticMethods);

        foreach ($methods as $method) {
            $getter = $method->getName();
            $this->assertNull($productPurchase->$getter());
        }
    }
}
