<?php


namespace Imdhemy\GooglePlay\ValueObjects;


final class Price
{
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
     * @param string $priceMicros
     * @param string $currency
     */
    public function __construct(string $priceMicros, string $currency)
    {
        $this->priceMicros = $priceMicros;
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getPriceMicros(): string
    {
        return $this->priceMicros;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }
}
