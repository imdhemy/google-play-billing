<?php

declare(strict_types=1);

namespace Tests\AAA;

use Faker\Provider\Base;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

final class DomainProvider extends Base
{
    public function subscriptionToken(): string
    {
        return $this->generator->uuid();
    }

    public function subscriptionPurchaseV2Response(): ResponseInterface
    {
        $body = $this->subscriptionV2Payload();

        return new Response(
            status: 200,
            headers: ['Content-Type' => 'application/json'],
            body: json_encode($body, JSON_PARTIAL_OUTPUT_ON_ERROR)
        );
    }

    public function subscriptionV2Payload(): array
    {
        return [
            'kind' => 'androidpublisher#subscriptionPurchaseV2',
            'regionCode' => 'US',
            'startTime' => '2024-01-15T10:00:00Z',
            'subscriptionState' => 'SUBSCRIPTION_STATE_ACTIVE',
            'latestOrderId' => 'GPA.3345-1234-5678-90123',
            'linkedPurchaseToken' => null,
            'pausedStateContext' => null,
            'canceledStateContext' => null,
            'testPurchase' => null,
            'acknowledgementState' => 'ACKNOWLEDGEMENT_STATE_ACKNOWLEDGED',
            'externalAccountIdentifiers' => [
                'externalAccountId' => 'user-ext-acc-88765',
                'obfuscatedExternalAccountId' => ' obfuscated-acc-id-aBcDeFgHiJkLmNoPqRsTuVwXyZ0123456789',
                'obfuscatedExternalProfileId' => 'obfuscated-prof-id-9876543210zYxWvUtSrQpOnMlKjIhGfEdCbA',
            ],
            'subscribeWithGoogleInfo' => [
                'profileId' => '109876543210987654321',
                'profileName' => 'Alex Smith',
                'emailAddress' => 'alex.smith.swg@example.com',
                'givenName' => 'Alex',
                'familyName' => 'Smith',
            ],
            'lineItems' => [
                [
                    'productId' => 'premium_monthly_v2',
                    'expiryTime' => '2025-01-15T10:00:00Z',
                    'autoRenewingPlan' => [
                        'autoRenewEnabled' => true,
                        'recurringPrice' => [
                            'units' => '12',
                            'nanos' => 990000000,
                            'currencyCode' => 'USD',
                        ],
                        'priceChangeDetails' => null,
                        'installmentDetails' => null,
                    ],
                    'prepaidPlan' => null,
                    'offerDetails' => [
                        'basePlanId' => 'premium-monthly',
                        'offerId' => 'intro-offer-7day',
                        'offerTags' => [
                            'initial_discount',
                            'seasonal_promo',
                        ],
                    ],
                    'deferredItemReplacement' => null,
                    'signupPromotion' => null,
                ],
            ],
        ];
    }
}
