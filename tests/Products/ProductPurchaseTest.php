<?php

namespace Imdhemy\GooglePlay\Tests\Products;

use Exception;
use Imdhemy\GooglePlay\Products\ProductPurchase;
use Imdhemy\GooglePlay\Tests\TestCase;
use Imdhemy\GooglePlay\ValueObjects\AcknowledgementState;
use Imdhemy\GooglePlay\ValueObjects\PurchaseType;
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
        $value = $this->faker->randomElement([0, 1, 2]);
        $productPurchase = ProductPurchase::fromArray(['purchaseState' => $value]);
        $this->assertEquals($value, $productPurchase->getPurchaseState()->getState());

        $zeroValue = 0;
        $productPurchase = ProductPurchase::fromArray(['purchaseState' => $zeroValue]);
        $this->assertTrue($productPurchase->getPurchaseState()->isPurchased());
    }

    /**
     * @test
     */
    public function test_consumption_state()
    {
        $value = $this->faker->randomElement([0, 1]);
        $productPurchase = ProductPurchase::fromArray(['consumptionState' => $value]);
        $this->assertEquals($value, $productPurchase->getConsumptionState()->getState());

        $zeroValue = 0;
        $productPurchase = ProductPurchase::fromArray(['consumptionState' => $zeroValue]);
        $this->assertFalse($productPurchase->getConsumptionState()->isConsumed());
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
            PurchaseType::TYPE_TEST,
            PurchaseType::TYPE_PROMO,
            PurchaseType::TYPE_REWARDED,
        ]);
        $productPurchase = ProductPurchase::fromArray(['purchaseType' => $value]);
        $this->assertEquals($value, $productPurchase->getPurchaseType()->getType());
    }

    /**
     * @test
     */
    public function test_acknowledgement_state()
    {
        $value = $this->faker->randomElement([
            AcknowledgementState::NOT_ACKNOWLEDGED,
            AcknowledgementState::ACKNOWLEDGED,
        ]);
        $productPurchase = ProductPurchase::fromArray(['acknowledgementState' => $value]);
        $this->assertEquals($value, $productPurchase->getAcknowledgementState()->getState());

        $zeroValue = 0;
        $productPurchase = ProductPurchase::fromArray(['acknowledgementState' => $zeroValue]);
        $this->assertFalse($productPurchase->getAcknowledgementState()->isAcknowledged());
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
}
