<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase\Subscription;

final readonly class SubscribeWithGoogleInfo
{
    public function __construct(
        public string $profileId,
        public string $profileName,
        public string $emailAddress,
        public string $givenName,
        public string $familyName,
    ) {
    }
}
