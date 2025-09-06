<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\Domain\Purchase\Subscription\CancellationType;
use Tests\TestCase;

final class CancellationTypeTest extends TestCase
{
    /** @test */
    public function instantiation(): void
    {
        $value = $this->faker->randomElement([
            'CANCELLATION_TYPE_UNSPECIFIED',
            'USER_REQUESTED_STOP_RENEWALS',
            'DEVELOPER_REQUESTED_STOP_PAYMENTS',
        ]);

        $actual = $this->normalizer->normalize($value, CancellationType::class);

        $this->assertInstanceOf(CancellationType::class, $actual);
        $this->assertSame($value, $actual->value);
    }
}
