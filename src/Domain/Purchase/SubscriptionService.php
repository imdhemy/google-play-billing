<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase;

use GuzzleHttp\Psr7\Request;
use Imdhemy\GooglePlay\Domain\NormalizerInterface;
use Psr\Http\Client\ClientInterface;
use UnexpectedValueException;

final readonly class SubscriptionService
{
    private const string GET_ENDPOINT = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/{packageName}/purchases/subscriptionsv2/tokens/{token}';

    public function __construct(
        private ClientInterface $client,
        private NormalizerInterface $normalizer,
    ) {
    }

    public function get(string $packageName, string $token): Subscription
    {
        $uri = str_replace(
            search: ['{packageName}', '{token}'],
            replace: [$packageName, $token],
            subject: self::GET_ENDPOINT
        );

        $request = new Request('GET', $uri);

        $response = $this->client->sendRequest($request);
        $data = \json_decode($response->getBody()->getContents(), true, 512, JSON_PARTIAL_OUTPUT_ON_ERROR);
        if (! is_array($data)) {
            throw new UnexpectedValueException('Expected response to be an array.');
        }

        return $this->normalizer->normalize(
            data: $data,
            type: Subscription::class
        );
    }
}
