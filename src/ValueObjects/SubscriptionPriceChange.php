<?php


namespace Imdhemy\GooglePlay\ValueObjects;

final class SubscriptionPriceChange
{
    /**
     * @var Price
     */
    private $newPrice;

    /**
     * @var PriceChangeState
     */
    private $state;

    /**
     * SubscriptionPriceChange constructor.
     * @param Price $newPrice
     * @param PriceChangeState $state
     */
    public function __construct(Price $newPrice, PriceChangeState $state)
    {
        $this->newPrice = $newPrice;
        $this->state = $state;
    }
    
    /**
     * @return Price
     */
    public function getNewPrice(): Price
    {
        return $this->newPrice;
    }

    /**
     * @return PriceChangeState
     */
    public function getState(): PriceChangeState
    {
        return $this->state;
    }
}
