<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase\Subscription;

/**
 * @see https://developers.google.cn/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#externalaccountidentifiers
 */
final readonly class ExternalAccountIdentifiers
{
    public function __construct(
        public ?string $externalAccountId,
        public string $obfuscatedExternalAccountId,
        public ?string $obfuscatedExternalProfileId,
    ) {
    }
}
