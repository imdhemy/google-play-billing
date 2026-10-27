<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase\Subscription;

use DateTimeImmutable;
use Imdhemy\GooglePlay\ValueObjects\Money;
use Imdhemy\GooglePlay\ValueObjects\Time;

/**
 * Price change related information of a subscription item.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#subscriptionitempricechangedetails
 *
 * @psalm-suppress DeprecatedClass Retained for backward compatibility until the next major release.
 */
final readonly class SubscriptionItemPriceChangeDetails
{
    public ?DateTimeImmutable $expectedPriceChangeAt;

    public function __construct(
        public Money $newPrice,
        public string $priceChangeMode,
        public string $priceChangeState,
        /** @deprecated Use {@see self::$expectedPriceChangeAt} instead. */
        public ?Time $expectedNewPriceChargeTime,
    ) {
        $this->expectedPriceChangeAt = null === $expectedNewPriceChargeTime ? null :
            new DateTimeImmutable($expectedNewPriceChargeTime->originalValue);
    }
}
