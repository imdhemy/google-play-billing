<?php

namespace Imdhemy\GooglePlay\Subscriptions;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Imdhemy\GooglePlay\ValueObjects\EmptyResponse;
use Imdhemy\GooglePlay\ValueObjects\SubscriptionDeferralInfo;
use Imdhemy\GooglePlay\ValueObjects\Time;

/**
 * Subscription Client
 */
class SubscriptionClient
{
    public const URI_GET = "https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/purchases/subscriptions/%s/tokens/%s";
    public const URI_ACKNOWLEDGE = "https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/purchases/subscriptions/%s/tokens/%s:acknowledge";
    public const URI_CANCEL = "https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/purchases/subscriptions/%s/tokens/%s:cancel";
    public const URI_DEFER = "https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/purchases/subscriptions/%s/tokens/%s:defer";
    public const URI_REFUND = "https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/purchases/subscriptions/%s/tokens/%s:refund";
    public const URI_REVOKE = "https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/purchases/subscriptions/%s/tokens/%s:revoke";

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
     * - simulates the API behaviour
     * - Get request was not consistent as it was acknowledged
     * @param string|null $developerPayload
     * @return EmptyResponse
     * @throws GuzzleException
     */
    public function acknowledge(?string $developerPayload = null): EmptyResponse
    {
        $uri = $this->getEndpoint(self::URI_ACKNOWLEDGE);
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
        $uri = $this->getEndpoint(self::URI_CANCEL);

        return new EmptyResponse($this->client->post($uri));
    }

    /**
     * @param SubscriptionDeferralInfo $subscriptionDeferralInfo
     * @return Time
     * @throws GuzzleException
     */
    public function defer(SubscriptionDeferralInfo $subscriptionDeferralInfo): Time
    {
        $uri = $this->getEndpoint(self::URI_DEFER);
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
        $uri = $this->getEndpoint(self::URI_GET);
        $response = $this->client->get($uri);
        $responseBody = json_decode((string)$response->getBody(), true);

        return SubscriptionPurchase::fromArray($responseBody);
    }

    /**
     * @return EmptyResponse
     * @throws GuzzleException
     */
    public function refund(): EmptyResponse
    {
        $uri = $this->getEndpoint(self::URI_REFUND);

        return new EmptyResponse($this->client->post($uri));
    }

    /**
     * @return EmptyResponse
     * @throws GuzzleException
     */
    public function revoke(): EmptyResponse
    {
        $uri = $this->getEndpoint(self::URI_REVOKE);

        return new EmptyResponse($this->client->post($uri));
    }

    /**
     * @param string $template
     * @return string
     */
    private function getEndpoint(string $template): string
    {
        return sprintf($template, $this->packageName, $this->subscriptionId, $this->token);
    }
}
