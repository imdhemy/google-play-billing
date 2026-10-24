<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Dto;

use DateTimeImmutable;
use Imdhemy\GooglePlay\ValueObjects\Time;

final readonly class DeferSubscriptionResponse
{
    public DateTimeImmutable $newExpiresAt;

    public function __construct(
        /** @deprecated Use $newExpiresAt instead. */
        public Time $newExpiryTimeMillis,
    ) {
        $this->newExpiresAt = DateTimeImmutable::createFromTimestamp((float)$newExpiryTimeMillis->originalValue / 1000);
    }
}
