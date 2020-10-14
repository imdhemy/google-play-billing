<?php

namespace Imdhemy\GooglePlay\Tests\ValueObjects;

use Imdhemy\GooglePlay\Tests\TestCase;
use Imdhemy\GooglePlay\ValueObjects\PurchaseType;

class PurchaseTypeTest extends TestCase
{
    /**
     * @test
     */
    public function test_it_can_be_constructed_by_null_value()
    {
        $purchaseType = new PurchaseType(null);
        $this->assertInstanceOf(PurchaseType::class, $purchaseType);
    }

    public function test_is_test()
    {
        $this->assertFalse((new PurchaseType(null))->isTest());
        $this->assertTrue((new PurchaseType(0))->isTest());
    }

    public function test_is_promo()
    {
        $this->assertFalse((new PurchaseType(null))->isPromo());
        $this->assertTrue((new PurchaseType(1))->isPromo());
    }

    public function test_is_rewarded()
    {
        $this->assertFalse((new PurchaseType(null))->isRewarded());
        $this->assertTrue((new PurchaseType(2))->isRewarded());
    }
}
