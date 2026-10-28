<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase\Subscription;

use DateTimeImmutable;
use Imdhemy\GooglePlay\ValueObjects\Time;

/**
 * @psalm-suppress DeprecatedClass Retained for backward compatibility until the next major release.
 */
final readonly class PausedStateContext
{
    public DateTimeImmutable $autoResumesAt;

    public function __construct(
        /** @deprecated Use {@see self::$autoResumesAt} instead. */
        public Time $autoResumeTime,
    ) {
        $this->autoResumesAt = new DateTimeImmutable($autoResumeTime->originalValue);
    }
}
