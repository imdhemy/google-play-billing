<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\DeveloperInitiatedCancellation;
use Imdhemy\GooglePlay\ValueObjects\ReplacementCancellation;
use Imdhemy\GooglePlay\ValueObjects\SystemInitiatedCancellation;
use Imdhemy\GooglePlay\ValueObjects\UserInitiatedCancellation;

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
