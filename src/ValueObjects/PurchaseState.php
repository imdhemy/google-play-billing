<?php


namespace Imdhemy\GooglePlay\ValueObjects;


final class PurchaseState
{
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
     * @return boolean
     */
    public function isPurchased(): bool
    {
        return $this->state === 0;
    }

    /**
     * @return boolean
     */
    public function isCancelled(): bool
    {
        return $this->state === 1;
    }

    /**
     * @return boolean
     */
    public function isPending(): bool
    {
        return $this->state === 2;
    }
}
