<?php

namespace Imdhemy\GooglePlay\ValueObjects;

class PurchaseType
{
    public const TYPE_TEST = 0;
    public const TYPE_PROMO = 1;
    public const TYPE_REWARDED = 2;

    /**
     * @var int
     */
    protected $type;

    /**
     * PurchaseType constructor
     *
     * @param int $type
     */
    public function __construct(int $type)
    {
        $this->type = $type;
    }

    public function isTest(): bool
    {
        return $this->type === self::TYPE_TEST;
    }

    public function isPromo(): bool
    {
        return $this->type === self::TYPE_PROMO;
    }

    /**
     * @return bool
     */
    public function isRewarded(): bool
    {
        return $this->type === self::TYPE_REWARDED;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->type;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->getType();
    }
}
