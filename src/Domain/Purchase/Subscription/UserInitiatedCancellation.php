<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase\Subscription;

use DateTimeImmutable;
use Imdhemy\GooglePlay\ValueObjects\Time;

/**
 * @see https://developers.google.cn/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#userinitiatedcancellation
 *
 * @psalm-suppress DeprecatedClass Retained for backward compatibility until the next major release.
 */
final readonly class UserInitiatedCancellation
{
    public DateTimeImmutable $canceledAt;

    public function __construct(
        public ?CancelSurveyResult $cancelSurveyResult,
        /** @deprecated Use {@see self::$canceledAt} instead. */
        public Time $cancelTime,
    ) {
        $this->canceledAt = new DateTimeImmutable($cancelTime->originalValue);
    }
}
