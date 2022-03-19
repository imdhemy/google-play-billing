<?php

namespace Tests\Products;

use Exception;
use Imdhemy\GooglePlay\Products\ProductPurchase;
use ReflectionClass;
use ReflectionMethod;
use Tests\TestCase;

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
        $body = [
            'kind' => 'someKind',
            'purchaseTimeMillis' => $this->faker->unixTime,
            'purchaseState' => random_int(0, 2),
            'consumptionState' => random_int(0, 1),
            'developerPayload' => null,
            'orderId' => $this->faker->uuid,
            'purchaseType' => random_int(0, 2),
            'acknowledgementState' => random_int(0, 1),
            'purchaseToken' => $this->faker->uuid,
            'productId' => $this->faker->company,
            'quantity' => 1,
            'obfuscatedExternalAccountId' => null,
            'obfuscatedExternalProfileId' => null,
            'regionCode' => $this->faker->countryCode,
        ];

        $this->assertInstanceOf(ProductPurchase::class, ProductPurchase::fromArray($body));
    }

    /**
     * @test
     */
    public function test_all_props_are_optional()
    {
        $productPurchase = ProductPurchase::fromArray();
        $this->assertInstanceOf(ProductPurchase::class, $productPurchase);

        $reflectionClass = new ReflectionClass($productPurchase);
        $publicMethods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);
        $staticMethods = $reflectionClass->getMethods(ReflectionMethod::IS_STATIC);

        $methods = array_map(function (ReflectionMethod $method) {
            return $method->getName();
        }, array_diff($publicMethods, $staticMethods));

        $methods = array_diff($methods, ['toArray', 'getPlainResponse']);

        foreach ($methods as $getter) {
            $this->assertNull($productPurchase->$getter());
        }
    }

    /**
     * @test
     */
    public function test_kind_attribute()
    {
        $kind = $this->faker->word();
        $productPurchase = ProductPurchase::fromArray(['kind' => $kind]);
        $this->assertEquals($kind, $productPurchase->getKind());
    }

    /**
     * @test
     */
    public function test_purchase_time()
    {
        $time = $this->faker->unixTime * 1000;
        $productPurchase = ProductPurchase::fromArray(['purchaseTimeMillis' => $time]);
        $this->assertEquals($time, $productPurchase->getPurchaseTime()->getCarbon()->getTimestampMs());
    }

    /**
     * @test
     */
    public function test_purchase_state()
    {
        $value = $this->faker->randomElement([
            ProductPurchase::PURCHASE_STATE_PURCHASED,
            ProductPurchase::PURCHASE_STATE_CANCELED,
            ProductPurchase::PURCHASE_STATE_PENDING,
        ]);
        $productPurchase = ProductPurchase::fromArray(['purchaseState' => $value]);
        $this->assertEquals($value, $productPurchase->getPurchaseState());
    }

    /**
     * @test
     */
    public function test_consumption_state()
    {
        $value = $this->faker->randomElement([
            ProductPurchase::CONSUMPTION_STATE_NOT_CONSUMED,
            ProductPurchase::CONSUMPTION_STATE_CONSUMED,
        ]);
        $productPurchase = ProductPurchase::fromArray(['consumptionState' => $value]);
        $this->assertEquals($value, $productPurchase->getConsumptionState());
    }

    /**
     * @test
     */
    public function test_developer_payload()
    {
        $value = json_encode(['user_id' => $this->faker->uuid()]);
        $productPurchase = ProductPurchase::fromArray(['developerPayload' => $value]);
        $this->assertEquals($value, $productPurchase->getDeveloperPayload());
    }

    /**
     * @test
     */
    public function test_order_id()
    {
        $value = $this->faker->uuid();
        $productPurchase = ProductPurchase::fromArray(['orderId' => $value]);
        $this->assertEquals($value, $productPurchase->getOrderId());
    }

    /**
     * @test
     */
    public function test_purchase_type()
    {
        $value = $this->faker->randomElement([
            ProductPurchase::PURCHASE_TYPE_TEST,
            ProductPurchase::PURCHASE_TYPE_PROMO,
            ProductPurchase::PURCHASE_TYPE_REWARDED,
        ]);
        $productPurchase = ProductPurchase::fromArray(['purchaseType' => $value]);
        $this->assertEquals($value, $productPurchase->getPurchaseType());
    }

    /**
     * @test
     */
    public function test_acknowledgement_state()
    {
        $value = $this->faker->randomElement([
            ProductPurchase::ACKNOWLEDGEMENT_STATE_NOT_ACKNOWLEDGED,
            ProductPurchase::ACKNOWLEDGEMENT_STATE_ACKNOWLEDGED,
        ]);
        $productPurchase = ProductPurchase::fromArray(['acknowledgementState' => $value]);
        $this->assertEquals($value, $productPurchase->getAcknowledgementState());
    }

    /**
     * @test
     */
    public function test_purchase_token()
    {
        $value = base64_encode($this->faker->uuid());
        $productPurchase = ProductPurchase::fromArray(['purchaseToken' => $value]);
        $this->assertEquals($value, $productPurchase->getPurchaseToken());
    }

    /**
     * @test
     */
    public function test_product_id()
    {
        $value = $this->faker->uuid();
        $productPurchase = ProductPurchase::fromArray(['productId' => $value]);
        $this->assertEquals($value, $productPurchase->getProductId());
    }

    /**
     * @test
     */
    public function test_quantity()
    {
        $value = $this->faker->numberBetween(1, 10);
        $productPurchase = ProductPurchase::fromArray(['quantity' => $value]);
        $this->assertEquals($value, $productPurchase->getQuantity());
    }

    /**
     * @test
     */
    public function test_obfuscated_external_account_id()
    {
        $value = $this->faker->uuid();
        $productPurchase = ProductPurchase::fromArray(['obfuscatedExternalAccountId' => $value]);
        $this->assertEquals($value, $productPurchase->getObfuscatedExternalAccountId());
    }

    /**
     * @test
     */
    public function test_obfuscated_external_profile_id()
    {
        $value = $this->faker->uuid();
        $productPurchase = ProductPurchase::fromArray(['obfuscatedExternalProfileId' => $value]);
        $this->assertEquals($value, $productPurchase->getObfuscatedExternalProfileId());
    }

    /**
     * @test
     */
    public function test_region_code()
    {
        $value = $this->faker->countryCode();
        $productPurchase = ProductPurchase::fromArray(['regionCode' => $value]);
        $this->assertEquals($value, $productPurchase->getRegionCode());
    }

    /**
     * @test
     * @throws Exception
     */
    public function it_is_array_able()
    {
        $body = [
            'kind' => 'someKind',
            'purchaseTimeMillis' => $this->faker->unixTime,
            'purchaseState' => random_int(0, 2),
            'consumptionState' => random_int(0, 1),
            'developerPayload' => null,
            'orderId' => $this->faker->uuid,
            'purchaseType' => random_int(0, 2),
            'acknowledgementState' => random_int(0, 1),
            'purchaseToken' => $this->faker->uuid,
            'productId' => $this->faker->company,
            'quantity' => 1,
            'obfuscatedExternalAccountId' => null,
            'obfuscatedExternalProfileId' => null,
            'regionCode' => $this->faker->countryCode,
        ];

        $productPurchase = ProductPurchase::fromArray($body);

        $this->assertEquals($body, $productPurchase->toArray());
    }
}
