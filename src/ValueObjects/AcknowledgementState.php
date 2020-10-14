<?php


namespace Imdhemy\GooglePlay\ValueObjects;


final class AcknowledgementState
{
    /**
     * @var int
     */
    private $acknowledged;

    /**
     * AcknowledgementState constructor
     * @param int $acknowledged
     */
    public function __construct(int $acknowledged)
    {
        $this->acknowledged = $acknowledged;
    }


    /**
     * @return boolean
     */
    public function isAcknowledged(): bool
    {
        return $this->acknowledged;
    }
}