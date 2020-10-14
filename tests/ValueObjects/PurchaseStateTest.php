<?php

namespace Imdhemy\GooglePlay\Tests\ValueObjects;

use Imdhemy\GooglePlay\Tests\TestCase;
use Imdhemy\GooglePlay\ValueObjects\PurchaseState;

class PurchaseStateTest extends TestCase
{
    /**
     * @test
     */
    public function test_is_purchased()
    {
        $purchaseState = new PurchaseState(0);
        $this->assertTrue($purchaseState->isPurchased());
    }

    /**
     * @test
     */
    public function test_is_cancelled()
    {
        $purchaseState = new PurchaseState(1);
        $this->assertTrue($purchaseState->isCancelled());
    }

    /**
     * @test
     */
    public function test_is_pending()
    {
        $purchaseState = new PurchaseState(2);
        $this->assertTrue($purchaseState->isPending());
    }
}
