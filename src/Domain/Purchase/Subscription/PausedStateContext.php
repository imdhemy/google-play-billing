<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\ValueObjects\Time;

final readonly class PausedStateContext
{
    public function __construct(public Time $autoResumeTime)
    {
    }
}
