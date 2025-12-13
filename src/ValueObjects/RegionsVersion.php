<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * The version of the available regions being used for the specified resource.
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
