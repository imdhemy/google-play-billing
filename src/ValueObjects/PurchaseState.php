<?php


namespace Imdhemy\GooglePlay\ValueObjects;

final class PurchaseState
{
    const STATE_PURCHASED = 0;
    const STATE_CANCELED = 1;
    const STATE_PENDING = 2;
    /**
     * @var int
     */
    private $state;

    /**
     * PurchaseState constructor
     *
     * @param int $state
     */
    public function __construct(int $state)
    {
        $this->state = $state;
    }

    /**
     * @return bool
     */
    public function isPurchased(): bool
    {
        return $this->state === self::STATE_PURCHASED;
    }

    /**
     * @return bool
     */
    public function isCancelled(): bool
    {
        return $this->state === self::STATE_CANCELED;
    }

    /**
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->state === self::STATE_PENDING;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->state;
    }

    /**
     * @return int
     */
    public function getState(): int
    {
        return $this->state;
    }

    /**
     * @return static
     */
    public static function fake(): self
    {
        return new self(mt_rand(self::STATE_PURCHASED, self::STATE_PENDING));
    }

    /**
     * @return static
     */
    public static function fakePurchased(): self
    {
        return new self(self::STATE_PURCHASED);
    }

    /**
     * @return static
     */
    public static function fakeCanceled(): self
    {
        return new self(self::STATE_CANCELED);
    }

    /**
     * @return static
     */
    public static function fakePending(): self
    {
        return new self(self::STATE_PENDING);
    }
}
