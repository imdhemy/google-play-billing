<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase\Subscription;

final readonly class VanityCode
{
    public function __construct(
        public string $promotionCode,
    ) {
    }
}
