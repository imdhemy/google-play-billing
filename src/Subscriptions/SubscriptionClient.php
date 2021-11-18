<?php

namespace Imdhemy\GooglePlay\Subscriptions;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Imdhemy\GooglePlay\ValueObjects\Time;

/**
 * Class Subscription
 * @package Imdhemy\GooglePlay\Subscriptions
 */
class SubscriptionClient
{
    private const URI_GET = "https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/purchases/subscriptions/%s/tokens/%s";
    private const URI_ACKNOWLEDGE = "https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/purchases/subscriptions/%s/tokens/%s:acknowledge";
    private const URI_CANCEL = "https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/purchases/subscriptions/%s/tokens/%s:cancel";
    private const URI_DEFER = "https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/purchases/subscriptions/%s/tokens/%s:defer";
    private const URI_REFUND = "https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/purchases/subscriptions/%s/tokens/%s:refund";
    private const URI_REVOKE = "https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/purchases/subscriptions/%s/tokens/%s:revoke";

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
     * @TODO: document this breaking change
     * @TODO: Implement Already acknowledged exception
     * - simulates the API behaviour
     * - Get request was not consistent as it was acknowledged
     * @param string|null $developerPayload
     * @return EmptyResponse
     * @throws GuzzleException
     */
    public function acknowledge(?string $developerPayload = null): EmptyResponse
    {
        $uri = sprintf(self::URI_ACKNOWLEDGE, $this->packageName, $this->subscriptionId, $this->token);
        $options = [
            'form_params' => [
                'developerPayload' => $developerPayload,
            ],
        ];

        return new EmptyResponse($this->client->post($uri, $options));
    }

    /**
     * @return EmptyResponse
     * @throws GuzzleException
     */
    public function cancel(): EmptyResponse
    {
        $uri = sprintf(self::URI_CANCEL, $this->packageName, $this->subscriptionId, $this->token);
        return new EmptyResponse($this->client->post($uri));
    }

    /**
     * @param SubscriptionDeferralInfo $subscriptionDeferralInfo
     * @return Time
     * @throws GuzzleException
     */
    public function defer(SubscriptionDeferralInfo $subscriptionDeferralInfo): Time
    {
        $uri = sprintf(self::URI_DEFER, $this->packageName, $this->subscriptionId, $this->token);
        $options = [
            'form_params' => [
                'deferralInfo' => $subscriptionDeferralInfo->toArray(),
            ],
        ];
        $response = $this->client->post($uri, $options);
        $newExpiryTime = json_decode((string)$response->getBody(), true)['newExpiryTimeMillis'];
        return new Time($newExpiryTime);
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

        return SubscriptionPurchase::fromArray($responseBody);
    }

    /**
     * @return EmptyResponse
     * @throws GuzzleException
     */
    public function refund(): EmptyResponse
    {
        $uri = sprintf(self::URI_REFUND, $this->packageName, $this->subscriptionId, $this->token);
        return new EmptyResponse($this->client->post($uri));
    }

    /**
     * @return EmptyResponse
     * @throws GuzzleException
     */
    public function revoke(): EmptyResponse
    {
        $uri = sprintf(self::URI_REFUND, $this->packageName, $this->subscriptionId, $this->token);
        return new EmptyResponse($this->client->post($uri));
    }
}
