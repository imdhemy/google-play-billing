<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * Information to a installment plan.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#installmentplan
 */
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
