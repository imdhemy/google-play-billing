<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\ValueObjects;

final readonly class InstallmentPlan
{
    public function __construct(
        public int $initialCommittedPaymentsCount,
        public int $subsequentCommittedPaymentsCount,
        public int $remainingCommittedPaymentsCount,
        public ?PendingCancellation $pendingCancellation,
    ) {
    }
}
