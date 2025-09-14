<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\DeferSubscriptionResponse;
use Tests\TestCase;

final class DeferSubscriptionResponseTest extends TestCase
{
    /** @test */
    public function instantiation(): void
    {
        $data = ['newExpiryTimeMillis' => '2021-09-01T00:00:00Z'];

        $actual = $this->normalizer->normalize($data, DeferSubscriptionResponse::class);

        $this->assertInstanceOf(DeferSubscriptionResponse::class, $actual);
        $this->assertSame($data['newExpiryTimeMillis'], $actual->newExpiryTimeMillis->originalValue);
    }
}
