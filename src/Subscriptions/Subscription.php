<?php


namespace Imdhemy\GooglePlay\Subscriptions;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Imdhemy\GooglePlay\ValueObjects\Time;

/**
 * Class Subscription
 * @package Imdhemy\GooglePlay\Subscriptions
 */
class Subscription
{
    /**
     *
     */
    const URI_GET = "https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/purchases/subscriptions/%s/tokens/%s";
    /**
     *
     */
    const URI_ACKNOWLEDGE = "https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/purchases/subscriptions/%s/tokens/%s:acknowledge";

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

    /**
     * @param string|null $developerPayload
     * @return SubscriptionPurchase
     * @throws GuzzleException
     */
    public function acknowledge(?string $developerPayload = null): SubscriptionPurchase
    {
        $subscriptionPurchase = $this->get();

        if (! $subscriptionPurchase->getAcknowledgementState()->isAcknowledged()) {
            $uri = sprintf(self::URI_ACKNOWLEDGE, $this->packageName, $this->subscriptionId, $this->token);
            $options = [
                'form_params' => [
                    'developerPayload' => $developerPayload,
                ],
            ];
            $this->client->post($uri, $options);
        }

        return $subscriptionPurchase;
    }

    /**
     *
     */
    public function cancel(): void
    {
        // TODO: implement cancel method
    }

    /**
     * @param SubscriptionDeferralInfo $subscriptionDeferralInfo
     * @return Time
     */
    public function defer(SubscriptionDeferralInfo $subscriptionDeferralInfo): Time
    {
        // TODO: implement defer method
    }

    /**
     * @return SubscriptionPurchase
     * @throws GuzzleException
     */
    public function get(): SubscriptionPurchase
    {
        $uri = sprintf(self::URI_GET, $this->packageName, $this->subscriptionId, $this->token);
        $response = $this->client->get($uri);
        $responseBody = json_decode($response->getBody(), true);

        return SubscriptionPurchase::fromResponseBody($responseBody);
    }

    /**
     *
     */
    public function refund(): void
    {
        // TODO: implement refund method
    }

    /**
     *
     */
    public function revoke(): void
    {
        // TODO: implement revoke method
    }
}
