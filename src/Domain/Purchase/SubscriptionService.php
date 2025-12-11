<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase;

use GuzzleHttp\Psr7\Request;
use Imdhemy\GooglePlay\Domain\Purchase\Entity\SubscriptionPurchase;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\CancellationType;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\RevocationContext;
use Imdhemy\GooglePlay\Domain\Serializer\NormalizerInterface;
use Imdhemy\GooglePlay\Domain\Serializer\SerializerInterface;
use Imdhemy\GooglePlay\Dto\DeferSubscriptionResponse;
use Imdhemy\GooglePlay\ValueObjects\SubscriptionDeferralInfo;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use UnexpectedValueException;

final readonly class SubscriptionService
{
    private const string GET_ENDPOINT = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/{packageName}/purchases/subscriptionsv2/tokens/{token}';
    private const string REVOKE_ENDPOINT = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/{packageName}/purchases/subscriptionsv2/tokens/{token}:revoke';
    private const string LEGACY_ACKNOWLEDGE_ENDPOINT = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/{packageName}/purchases/subscriptions/tokens/{token}:acknowledge';
    private const string LEGACY_CANCEL_ENDPOINT = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/{packageName}/purchases/subscriptions/tokens/{token}:cancel';
    private const string LEGACY_DEFER_ENDPOINT = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/{packageName}/purchases/subscriptions/{subscriptionId}/tokens/{token}:defer';
    private const string LEGACY_REFUND_ENDPOINT = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/{packageName}/purchases/subscriptions/{subscriptionId}/tokens/{token}:refund';

    private const array HEADERS = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ];

    public function __construct(
        private ClientInterface $client,
        private NormalizerInterface $normalizer,
        private SerializerInterface $serializer,
    ) {
    }

    public function get(string $packageName, string $token): SubscriptionPurchase
    {
        $data = $this->doGet(packageName: $packageName, token: $token);

        return $this->normalizer->normalize(data: $data, type: SubscriptionPurchase::class);
    }

    public function revoke(string $packageName, string $token, RevocationContext $revocationContext): void
    {
        $uri = str_replace(
            search: ['{packageName}', '{token}'],
            replace: [$packageName, $token],
            subject: self::REVOKE_ENDPOINT
        );

        $request = new Request(
            method: 'POST',
            uri: $uri,
            headers: self::HEADERS,
            body: $this->serializer->serialize(data: compact('revocationContext'))
        );

        $this->client->sendRequest($request);
    }

    public function legacyAcknowledge(string $packageName, string $token, string $developerPayload): void
    {
        $uri = str_replace(
            search: ['{packageName}', '{token}'],
            replace: [$packageName, $token],
            subject: self::LEGACY_ACKNOWLEDGE_ENDPOINT
        );

        $request = new Request(
            method: 'POST',
            uri: $uri,
            headers: self::HEADERS,
            body: $this->serializer->serialize(data: ['developerPayload' => $developerPayload])
        );

        $this->client->sendRequest($request);
    }

    public function legacyCancel(string $packageName, string $token, CancellationType $cancellationType): void
    {
        $uri = str_replace(
            search: ['{packageName}', '{token}'],
            replace: [$packageName, $token],
            subject: self::LEGACY_CANCEL_ENDPOINT
        );

        $request = new Request(
            method: 'POST',
            uri: $uri,
            headers: self::HEADERS,
            body: $this->serializer->serialize(data: ['cancellationType' => $cancellationType->value])
        );

        $this->client->sendRequest($request);
    }

    public function legacyDefer(string $packageName, string $subscriptionId, string $token, SubscriptionDeferralInfo $deferralInfo): DeferSubscriptionResponse
    {
        $data = $this->doLegacyDefer($packageName, $subscriptionId, $token, $deferralInfo);

        return $this->normalizer->normalize(data: $data, type: DeferSubscriptionResponse::class);
    }

    public function legacyRefund(string $packageName, string $subscriptionId, string $token): void
    {
        $uri = str_replace(
            search: ['{packageName}', '{subscriptionId}', '{token}'],
            replace: [$packageName, $subscriptionId, $token],
            subject: self::LEGACY_REFUND_ENDPOINT
        );

        $request = new Request(
            method: 'POST',
            uri: $uri,
            headers: self::HEADERS
        );

        $this->client->sendRequest($request);
    }

    private function doGet(string $packageName, string $token): array
    {
        $uri = str_replace(
            search: ['{packageName}', '{token}'],
            replace: [$packageName, $token],
            subject: self::GET_ENDPOINT
        );

        $request = new Request(
            method: 'GET',
            uri: $uri,
            headers: self::HEADERS
        );

        $response = $this->client->sendRequest($request);

        return $this->getResponseBody($response);
    }

    private function doLegacyDefer(string $packageName, string $subscriptionId, string $token, SubscriptionDeferralInfo $deferralInfo): array
    {
        $uri = str_replace(
            search: ['{packageName}', '{subscriptionId}', '{token}'],
            replace: [$packageName, $subscriptionId, $token],
            subject: self::LEGACY_DEFER_ENDPOINT
        );

        $request = new Request(
            method: 'POST',
            uri: $uri,
            headers: self::HEADERS,
            body: $this->serializer->serialize(data: ['deferralInfo' => $deferralInfo->toArray()])
        );

        $response = $this->client->sendRequest($request);

        return $this->getResponseBody($response);
    }

    private function getResponseBody(ResponseInterface $response): array
    {
        $responseBody = json_decode((string)$response->getBody(), true, 512, JSON_PARTIAL_OUTPUT_ON_ERROR);

        if (! is_array($responseBody)) {
            throw new UnexpectedValueException('Expected response to be an array.');
        }

        return $responseBody;
    }
}
