<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\ValueObjects;

final readonly class DeferSubscriptionResponse
{
    public function __construct(public Time $newExpiryTimeMillis)
    {
    }
}
