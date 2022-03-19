<?php

namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * Introductory Price Info
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptions#introductorypriceinfo
 */
final class IntroductoryPriceInfo
{
    public const PERIOD_WEEK = 'P1W';
    public const PERIOD_MONTH = 'P1M';
    public const PERIOD_THREE_MONTHS = 'P3M';
    public const PERIOD_SIX_MONTHS = 'P6M';
    public const PERIOD_ONE_YEAR = 'P1Y';

    public const INTRO_PRICE_PERIODS = [
        self::PERIOD_WEEK,
        self::PERIOD_MONTH,
        self::PERIOD_THREE_MONTHS,
        self::PERIOD_SIX_MONTHS,
        self::PERIOD_ONE_YEAR,
    ];

    public const PRICE_PERIOD = 'introductoryPricePeriod';
    public const PRICE_CYCLES = 'introductoryPriceCycles';
    public const AMOUNT_MICROS = 'introductoryPriceAmountMicros';
    public const CURRENCY_CODE = 'introductoryPriceCurrencyCode';

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
        return new self(
            $introductoryPriceInfo[self::CURRENCY_CODE],
            $introductoryPriceInfo[self::AMOUNT_MICROS],
            $introductoryPriceInfo[self::PRICE_PERIOD],
            $introductoryPriceInfo[self::PRICE_CYCLES]
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            self::CURRENCY_CODE => $this->getCurrencyCode(),
            self::AMOUNT_MICROS => $this->getAmountMicros(),
            self::PRICE_PERIOD => $this->getPeriod(),
            self::PRICE_CYCLES => $this->getCycles(),
        ];
    }

    /**
     * @return string
     */
    public function getCurrencyCode(): string
    {
        return $this->introductoryPriceCurrencyCode;
    }

    /**
     * @return string
     */
    public function getAmountMicros(): string
    {
        return $this->introductoryPriceAmountMicros;
    }

    /**
     * @return string
     */
    public function getPeriod(): string
    {
        return $this->introductoryPricePeriod;
    }

    /**
     * @return int
     */
    public function getCycles(): int
    {
        return $this->introductoryPriceCycles;
    }
}
