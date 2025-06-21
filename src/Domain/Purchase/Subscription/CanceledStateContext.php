<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase\Subscription;

final readonly class CanceledStateContext
{
    public function __construct(
        public ?UserInitiatedCancellation $userInitiatedCancellation = null,
        public ?SystemInitiatedCancellation $systemInitiatedCancellation = null,
        public ?DeveloperInitiatedCancellation $developerInitiatedCancellation = null,
        public ?ReplacementCancellation $replacementCancellation = null,
    ) {
    }
}
