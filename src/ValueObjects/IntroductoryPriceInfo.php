<?php


namespace Imdhemy\GooglePlay\ValueObjects;


final class IntroductoryPriceInfo
{
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
}
