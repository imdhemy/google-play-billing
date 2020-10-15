<?php


namespace Imdhemy\GooglePlay\Subscriptions;


use GuzzleHttp\Client;
use Imdhemy\GooglePlay\ValueObjects\Time;

class Subscription
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $packageName;

    /**
     * @var string
     */
    protected $subscriptionId;

    /**
     * @var string
     */
    protected $token;

    /**
     * Subscription constructor.
     * @param Client $client
     * @param string $packageName
     * @param string $subscriptionId
     * @param string $token
     */
    public function __construct(Client $client, string $packageName, string $subscriptionId, string $token)
    {
        $this->client = $client;
        $this->packageName = $packageName;
        $this->subscriptionId = $subscriptionId;
        $this->token = $token;
    }

    public function acknowledge(): void
    {
    }

    public function cancel(): void
    {
    }

    public function defer(SubscriptionDeferralInfo $subscriptionDeferralInfo): Time
    {
    }

    public function get(): SubscriptionPurchase
    {
    }

    public function refund(): void
    {
    }

    public function revoke(): void
    {
    }
}
