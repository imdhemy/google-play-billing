<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\FullRefund;
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
