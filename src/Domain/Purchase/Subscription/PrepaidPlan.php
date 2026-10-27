<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase\Subscription;

use DateTimeImmutable;
use Imdhemy\GooglePlay\ValueObjects\Time;

/**
 * Information related to a prepaid plan.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#prepaidplan
 *
 * @psalm-suppress DeprecatedClass Retained for backward compatibility until the next major release.
 */
final readonly class PrepaidPlan
{
    public ?DateTimeImmutable $extensionAllowedAfter;

    public function __construct(
        /** @deprecated Use {@see self::$extensionAllowedAfter} instead. */
        public ?Time $allowExtendAfterTime = null,
    ) {
        $this->extensionAllowedAfter = null === $allowExtendAfterTime ? null :
            new DateTimeImmutable($allowExtendAfterTime->originalValue);
    }
}
