<?php


namespace Imdhemy\GooglePlay\Subscriptions;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Imdhemy\GooglePlay\ValueObjects\Time;

class Subscription
{
    const URI_GET = "https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/purchases/subscriptions/%s/tokens/%s";
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
     * @throws GuzzleException
     */
    public function acknowledge(?string $developerPayload = null): void
    {
        $isAcknowledged = $this->get()->getAcknowledgementState()->isAcknowledged();
        if (!$isAcknowledged) {
            $uri = sprintf(self::URI_ACKNOWLEDGE, $this->packageName, $this->subscriptionId, $this->token);
            $options = [
                'form_params' => [
                    'developerPayload' => $developerPayload
                ]
            ];
            $this->client->post($uri, $options);
        }
    }

    public function cancel(): void
    {
    }

    public function defer(SubscriptionDeferralInfo $subscriptionDeferralInfo): Time
    {
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

    public function refund(): void
    {
    }

    public function revoke(): void
    {
    }
}
