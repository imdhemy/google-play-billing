<?php


namespace Imdhemy\GooglePlay\ValueObjects;


final class PriceChangeState
{
    /**
     * @var int
     */
    private $value;

    /**
     * PriceChangeState constructor.
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @return bool
     */
    public function isOutstanding(): bool
    {
        return $this->value === 0;
    }

    /**
     * @return bool
     */
    public function isAccepted(): bool
    {
        return $this->value === 0;
    }
}
