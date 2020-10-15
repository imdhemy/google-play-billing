<?php


namespace Imdhemy\GooglePlay\ValueObjects;


/**
 * Class CancelReason
 * @package Imdhemy\GooglePlay\ValueObjects
 */
final class CancelReason
{
    /**
     * @var int
     */
    private $value;

    /**
     * CancelReason constructor.
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @return bool
     */
    public function cancelledByser(): bool
    {
        return $this->value === 0;
    }

    /**
     * @return bool
     */
    public function cancelledBySystem(): bool
    {
        return $this->value === 1;
    }

    /**
     * @return bool
     */
    public function replacedByNewSubscription(): bool
    {
        return $this->value === 2;
    }

    /**
     * @return bool
     */
    public function cancelledByDeveloper(): bool
    {
        return $this->value === 3;
    }
}
