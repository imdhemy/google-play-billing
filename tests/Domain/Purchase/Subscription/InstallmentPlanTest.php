<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\Domain\Purchase\Subscription\InstallmentPlan;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\PendingCancellation;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class InstallmentPlanTest extends TestCase
{
    #[test]
    public function instantiate(): void
    {
        $input = [
            'initialCommittedPaymentsCount' => 3,
            'remainingCommittedPaymentsCount' => 1,
            'subsequentCommittedPaymentsCount' => 2,
            'pendingCancellation' => [],
        ];

        $actual = $this->normalizer->normalize($input, InstallmentPlan::class);

        $this->assertInstanceOf(InstallmentPlan::class, $actual);
        $this->assertSame(3, $actual->initialCommittedPaymentsCount);
        $this->assertSame(2, $actual->subsequentCommittedPaymentsCount);
        $this->assertSame(1, $actual->remainingCommittedPaymentsCount);
        $this->assertInstanceOf(PendingCancellation::class, $actual->pendingCancellation);
    }

    #[test]
    public function instantiate_without_optional_fields(): void
    {
        $input = [
            'initialCommittedPaymentsCount' => 5,
            'remainingCommittedPaymentsCount' => 2,
        ];

        $actual = $this->normalizer->normalize($input, InstallmentPlan::class);

        $this->assertInstanceOf(InstallmentPlan::class, $actual);
        $this->assertSame(5, $actual->initialCommittedPaymentsCount);
        $this->assertNull($actual->subsequentCommittedPaymentsCount);
        $this->assertSame(2, $actual->remainingCommittedPaymentsCount);
        $this->assertNull($actual->pendingCancellation);
    }
}
