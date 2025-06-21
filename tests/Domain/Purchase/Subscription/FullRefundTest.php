<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\Domain\Purchase\Subscription\FullRefund;
use Tests\TestCase;

final class FullRefundTest extends TestCase
{
    /** @test */
    public function create(): void
    {
        $fullRefund = FullRefund::create();

        $this->assertEmpty(get_object_vars($fullRefund));
    }
}
