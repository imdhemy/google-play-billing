<?php

namespace Imdhemy\GooglePlay\ValueObjects;

class SubscriptionDeferralInfo
{
    /**
     * @var string
     */
    private $expectedExpiryTimeMillis;

    /**
     * @var string
     */
    private $desiredExpiryTimeMillis;

    /**
     * @param string $expectedExpiryTimeMillis
     * @param string $desiredExpiryTimeMillis
     */
    public function __construct(string $expectedExpiryTimeMillis, string $desiredExpiryTimeMillis)
    {
        $this->expectedExpiryTimeMillis = $expectedExpiryTimeMillis;
        $this->desiredExpiryTimeMillis = $desiredExpiryTimeMillis;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'expectedExpiryTimeMillis' => $this->expectedExpiryTimeMillis,
            'desiredExpiryTimeMillis' => $this->desiredExpiryTimeMillis,
        ];
    }
}
