<?php


namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * Class ConsumptionState
 * @package Imdhemy\GooglePlay\ValueObjects
 */
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

    /**
     * @return static
     */
    public static function fake(): self
    {
        return new self(mt_rand(0, 1));
    }

    /**
     * @return static
     */
    public static function fakeConsumed(): self
    {
        return new self(1);
    }

    /**
     * @return static
     */
    public static function fakeNotConsumed(): self
    {
        return new self(0);
    }
}
