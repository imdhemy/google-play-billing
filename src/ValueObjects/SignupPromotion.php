<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * Represents the promotion applied on an item when purchased.
 * Only one of OneTimeCode or VanityCode can be set.
 *
 * @see https://developers.google.cn/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#signuppromotion
 */
final readonly class SignupPromotion
{
    public function __construct(
        public ?OneTimeCode $oneTimeCode = null,
        public ?VanityCode $vanityCode = null,
    ) {
    }
}
