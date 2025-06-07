<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\ValueObjects;

final readonly class PausedStateContext
{
    public function __construct(public Time $autoResumeTime)
    {
    }
}
