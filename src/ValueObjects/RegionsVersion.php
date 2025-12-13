<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * Represents an amount of money with its currency type.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/RegionsVersion
 */
final readonly class RegionsVersion
{
    public function __construct(
        public string $version,
    ) {
    }
}
