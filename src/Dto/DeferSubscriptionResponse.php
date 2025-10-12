<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Dto;

use Imdhemy\GooglePlay\ValueObjects\Time;

final readonly class DeferSubscriptionResponse
{
    public function __construct(public Time $newExpiryTimeMillis)
    {
    }
}
