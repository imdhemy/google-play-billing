<?php


namespace Imdhemy\GooglePlay\ValueObjects;

final class ConsumptionState
{
    /**
     * @var int
     */
    protected $consumed;

    /**
     * ConsumptionState constructor
     * @param int $consumed
     */
    public function __construct(int $consumed)
    {
        $this->consumed = $consumed;
    }

    /**
     * @return bool
     */
    public function isConsumed(): bool
    {
        return $this->consumed === 1;
    }
}
