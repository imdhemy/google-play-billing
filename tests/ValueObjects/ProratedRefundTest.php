<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\ProratedRefund;
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
