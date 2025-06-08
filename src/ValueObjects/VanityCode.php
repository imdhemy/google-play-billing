<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\ValueObjects;

final readonly class VanityCode
{
    public function __construct(
        public string $promotionCode,
    ) {
    }
}
