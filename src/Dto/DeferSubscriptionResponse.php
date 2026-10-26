<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Dto;

use DateTimeImmutable;
use Imdhemy\GooglePlay\ValueObjects\Time;

/**
 * @psalm-suppress DeprecatedClass Retained for backward compatibility until the next major release.
 */
final readonly class DeferSubscriptionResponse
{
    public DateTimeImmutable $newExpiryAt;

    public function __construct(
        /** @deprecated Use {@see self::$newExpiryAt} instead. */
        public Time $newExpiryTimeMillis,
    ) {
        $this->newExpiryAt = DateTimeImmutable::createFromTimestamp((float)$newExpiryTimeMillis->originalValue / 1000);
    }
}
