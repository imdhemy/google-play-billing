<?php

namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * Price
 * Definition of a price, i.e. currency and units.
 */
final class Price
{
    public const PRICE_MICROS = 'priceMicros';
    public const CURRENCY = 'currency';

    /**
     * @var string
     */
    private $priceMicros;

    /**
     * @var string
     */
    private $currency;

    /**
     * Price constructor.
     */
    public function __construct(string $priceMicros, string $currency)
    {
        $this->priceMicros = $priceMicros;
        $this->currency = $currency;
    }

    /**
     * @return static
     */
    public static function fromArray(array $attributes): self
    {
        return new self(
            $attributes[self::PRICE_MICROS],
            $attributes[self::CURRENCY]
        );
    }

    public function getPriceMicros(): string
    {
        return $this->priceMicros;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * Get array representation of current value.
     */
    public function toArray(): array
    {
        return [
            self::PRICE_MICROS => $this->getPriceMicros(),
            self::CURRENCY => $this->getCurrency(),
        ];
    }

    public function equals(Price $priceObj): bool
    {
        if ($this->getCurrency() === $priceObj->getCurrency()) {
            return $this->getPriceMicros() === $priceObj->getPriceMicros();
        }

        return false;
    }
}
