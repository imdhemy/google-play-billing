<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Monetization\Application\ConvertRegionPrices;

use Imdhemy\GooglePlay\ValueObjects\Money;
use JsonSerializable;

final readonly class ConvertRegionPricesQuery implements JsonSerializable
{
    public function __construct(
        public string $packageName,
        public Money $price,
        public ?string $productTaxCategoryCode = null,
    ) {
    }

    public function jsonSerialize(): array
    {
        return array_filter([
            'price' => $this->price,
            'productTaxCategoryCode' => $this->productTaxCategoryCode,
        ], static fn (mixed $value): bool => null !== $value);
    }
}
