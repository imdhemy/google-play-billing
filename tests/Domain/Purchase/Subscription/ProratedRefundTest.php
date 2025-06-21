<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\Domain\Purchase\Subscription\ProratedRefund;
use Tests\TestCase;

final class ProratedRefundTest extends TestCase
{
    /** @test */
    public function create(): void
    {
        $proratedRefund = ProratedRefund::create();

        $this->assertEmpty(get_object_vars($proratedRefund));
    }
}
