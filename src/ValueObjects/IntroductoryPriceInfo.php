<?php


namespace Imdhemy\GooglePlay\ValueObjects;

final class IntroductoryPriceInfo
{
    const INTRO_PRICE_PERIODS = ['P1W', 'P1M', 'P3M', 'P6M', 'P1Y'];
    /**
     * @var string
     */
    private $introductoryPriceCurrencyCode;

    /**
     * @var string
     */
    private $introductoryPriceAmountMicros;

    /**
     * @var string
     */
    private $introductoryPricePeriod;

    /**
     * @var int
     */
    private $introductoryPriceCycles;

    /**
     * IntroductoryPriceInfo constructor.
     * @param string $introductoryPriceCurrencyCode
     * @param string $introductoryPriceAmountMicros
     * @param string $introductoryPricePeriod
     * @param int $introductoryPriceCycles
     */
    public function __construct(
        string $introductoryPriceCurrencyCode,
        string $introductoryPriceAmountMicros,
        string $introductoryPricePeriod,
        int $introductoryPriceCycles
    ) {
        $this->introductoryPriceCurrencyCode = $introductoryPriceCurrencyCode;
        $this->introductoryPriceAmountMicros = $introductoryPriceAmountMicros;
        $this->introductoryPricePeriod = $introductoryPricePeriod;
        $this->introductoryPriceCycles = $introductoryPriceCycles;
    }

    /**
     * @param array $introductoryPriceInfo
     * @return static
     */
    public static function fromArray(array $introductoryPriceInfo): self
    {
        return new self(...array_values($introductoryPriceInfo));
    }

    /**
     * @return static
     */
    public static function fake(): self
    {
        $currencyCode = Price::CURRENCY_CODES[array_rand(Price::CURRENCY_CODES)];
        $priceAmmountMicros = mt_rand(1, 100) * 1000;
        $pricePeriod = self::INTRO_PRICE_PERIODS[array_rand(self::INTRO_PRICE_PERIODS)];
        $cycles = mt_rand(1, 10);
        
        return new self($currencyCode, $priceAmmountMicros, $pricePeriod, $cycles);
    }
}
