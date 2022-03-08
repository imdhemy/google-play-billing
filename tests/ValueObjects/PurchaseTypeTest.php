<?php

namespace Imdhemy\GooglePlay\Tests\ValueObjects;

use Imdhemy\GooglePlay\Tests\TestCase;
use Imdhemy\GooglePlay\ValueObjects\PurchaseType;

class PurchaseTypeTest extends TestCase
{
    /**
     * @test
     */
    public function is_test()
    {
        $this->assertTrue((new PurchaseType(PurchaseType::TYPE_TEST))->isTest());
    }

    /**
     * @test
     */
    public function is_promo()
    {
        $this->assertTrue((new PurchaseType(PurchaseType::TYPE_PROMO))->isPromo());
    }

    /**
     * @test
     */
    public function is_rewarded()
    {
        $this->assertTrue((new PurchaseType(PurchaseType::TYPE_REWARDED))->isRewarded());
    }
}
