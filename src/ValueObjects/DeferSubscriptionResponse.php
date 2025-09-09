<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\ValueObjects;

final class DeferSubscriptionResponse
{
    public function __construct(public string $newExpiryTimeMillis)
    {
    }
}
