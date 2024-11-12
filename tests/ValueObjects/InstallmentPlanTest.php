<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\InstallmentPlan;
use Tests\TestCase;

final class InstallmentPlanTest extends TestCase
{
    /** @test */
    public function properties(): void
    {
        $data = [
            'initialCommittedPaymentsCount' => $this->faker->numberBetween(0, 10),
            'subsequentCommittedPaymentsCount' => $this->faker->numberBetween(0, 10),
            'remainingCommittedPaymentsCount' => $this->faker->numberBetween(0, 10),
            'pendingCancellation' => '',
        ];

        $actual = $this->normalizer->normalize($data, InstallmentPlan::class);

        $this->assertEquals($data['initialCommittedPaymentsCount'], $actual->initialCommittedPaymentsCount);
        $this->assertEquals($data['subsequentCommittedPaymentsCount'], $actual->subsequentCommittedPaymentsCount);
        $this->assertEquals($data['remainingCommittedPaymentsCount'], $actual->remainingCommittedPaymentsCount);
        $this->assertNotNull($actual->pendingCancellation);
    }

    /** @test */
    public function when_pending_cancellation_is_missing(): void
    {
        $data = [
            'initialCommittedPaymentsCount' => $this->faker->numberBetween(0, 10),
            'subsequentCommittedPaymentsCount' => $this->faker->numberBetween(0, 10),
            'remainingCommittedPaymentsCount' => $this->faker->numberBetween(0, 10),
        ];

        $actual = $this->normalizer->normalize($data, InstallmentPlan::class);

        $this->assertNull($actual->pendingCancellation);
    }
}
