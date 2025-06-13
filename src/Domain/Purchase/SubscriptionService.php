<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase;

use GuzzleHttp\Psr7\Request;
use Imdhemy\GooglePlay\Domain\NormalizerInterface;
use Imdhemy\GooglePlay\Domain\SerializerInterface;
use Imdhemy\GooglePlay\ValueObjects\RevocationContext;
use Psr\Http\Client\ClientInterface;
use UnexpectedValueException;

final readonly class SubscriptionService
{
    private const string GET_ENDPOINT = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/{packageName}/purchases/subscriptionsv2/tokens/{token}';
    private const string REVOKE_ENDPOINT = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/{packageName}/purchases/subscriptionsv2/tokens/{token}:revoke';

    public function __construct(
        private ClientInterface $client,
        private NormalizerInterface $normalizer,
        private SerializerInterface $serializer,
    ) {
    }

    public function get(string $packageName, string $token): Subscription
    {
        $uri = str_replace(
            search: ['{packageName}', '{token}'],
            replace: [$packageName, $token],
            subject: self::GET_ENDPOINT
        );

        $request = new Request(
            method: 'GET',
            uri: $uri,
            headers: [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        );

        $data = $this->doGet($request);

        return $this->normalizer->normalize(data: $data, type: Subscription::class);
    }

    public function revoke(string $packageName, string $token, RevocationContext $revocationContext): void
    {
        $uri = str_replace(
            search: ['{packageName}', '{token}'],
            replace: [$packageName, $token],
            subject: self::REVOKE_ENDPOINT
        );

        $body = $this->serializer->serialize(data: compact('revocationContext'));

        $request = new Request(
            method: 'POST',
            uri: $uri,
            headers: [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            body: $body
        );

        $this->client->sendRequest($request);
    }

    private function doGet(Request $request): array
    {
        $response = $this->client->sendRequest($request);
        $data = \json_decode($response->getBody()->getContents(), true, 512, JSON_PARTIAL_OUTPUT_ON_ERROR);

        if (! is_array($data)) {
            throw new UnexpectedValueException('Expected response to be an array.');
        }

        return $data;
    }
}
