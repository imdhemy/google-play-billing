<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Order\Model;

use JsonSerializable;

/**
 * Coarse location where content consumption occurred.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/orders/reviewrefund#coarselocation
 */
final readonly class CoarseLocation implements JsonSerializable
{
    /**
     * @param string      $regionCode         CLDR region code of the country or region, for example "CH"
     * @param string|null $administrativeArea Highest administrative subdivision used for postal addresses
     * @param string|null $locality           City or town
     * @param string|null $sublocality        Neighborhood, borough, or city district
     */
    public function __construct(
        public string $regionCode,
        public ?string $administrativeArea = null,
        public ?string $locality = null,
        public ?string $sublocality = null,
    ) {
    }

    public function jsonSerialize(): array
    {
        return array_filter([
            'regionCode' => $this->regionCode,
            'administrativeArea' => $this->administrativeArea,
            'locality' => $this->locality,
            'sublocality' => $this->sublocality,
        ], static fn (mixed $value): bool => null !== $value);
    }
}
