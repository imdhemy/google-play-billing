<?php


namespace Imdhemy\GooglePlay\ValueObjects;

class PurchaseType
{
    const TYPE_TEST = 0;
    const TYPE_PROMO = 1;
    const TYPE_REWARDED = 2;

    /**
     * @var int|null
     */
    protected $type;

    /**
     * PurchaseType constructor
     *
     * @param int|null $type
     */
    public function __construct(?int $type = null)
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
     * @return int|null
     */
    public function getType(): ?int
    {
        return $this->type;
    }

    /**
     * @return $this
     */
    public static function fake(): self
    {
        return new self(mt_rand(self::TYPE_TEST, self::TYPE_REWARDED));
    }

    /**
     * @return static
     */
    public static function fakeTest(): self
    {
        return new self(self::TYPE_TEST);
    }

    /**
     * @return static
     */
    public static function fakePromo(): self
    {
        return new self(self::TYPE_PROMO);
    }

    /**
     * @return static
     */
    public static function fakeRewarded(): self
    {
        return new self(self::TYPE_REWARDED);
    }
}
