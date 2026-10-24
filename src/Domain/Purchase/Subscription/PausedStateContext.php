<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase\Subscription;

use DateTimeImmutable;
use Imdhemy\GooglePlay\ValueObjects\Time;

final readonly class PausedStateContext
{
    public DateTimeImmutable $autoResumedAt;

    public function __construct(
        /** @deprecated Use $autoResumedAt instead. */
        public Time $autoResumeTime,
    ) {
        $this->autoResumedAt = new DateTimeImmutable($autoResumeTime->originalValue);
    }
}
