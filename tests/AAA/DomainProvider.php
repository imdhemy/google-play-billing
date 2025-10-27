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

    public function productToken(): string
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

    public function subscriptionPurchaseV2ResponseWithoutExternalAccountId(): ResponseInterface
    {
        $body = $this->subscriptionV2PayloadWithoutExternalAccountId();

        return new Response(
            status: 200,
            headers: ['Content-Type' => 'application/json'],
            body: json_encode($body, JSON_PARTIAL_OUTPUT_ON_ERROR)
        );
    }

    public function productPurchaseResponse(): ResponseInterface
    {
        $body = $this->productPurchasePayload();

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

    public function subscriptionV2PayloadWithoutExternalAccountId(): array
    {
        return [
            'kind' => 'androidpublisher#subscriptionPurchaseV2',
            'startTime' => '2025-10-24T11:03:42.097Z',
            'regionCode' => 'DE',
            'subscriptionState' => 'SUBSCRIPTION_STATE_ACTIVE',
            'latestOrderId' => 'GPA.3345-1234-5678-90123',
            'testPurchase' => [],
            'acknowledgementState' => 'ACKNOWLEDGEMENT_STATE_ACKNOWLEDGED',
            'externalAccountIdentifiers' => [
                // externalAccountId and obfuscatedExternalProfileId are optional
                'obfuscatedExternalAccountId' => 'VioUT4kHwh0ur8crMexs',
            ],
            'lineItems' => [
                [
                    'productId' => 'subscription.test',
                    'expiryTime' => '2025-10-24T11:06:41.541Z',
                    'autoRenewingPlan' => [
                        'autoRenewEnabled' => true,
                        'recurringPrice' => [
                            'currencyCode' => 'EUR',
                            'units' => '4',
                            'nanos' => 190000000,
                        ],
                    ],
                    'offerDetails' => [
                        'basePlanId' => 'test-one-month',
                        'offerId' => 'test-one-month-trial',
                    ],
                    'latestSuccessfulOrderId' => 'GPA.3345-1234-5678-90123',
                ],
            ],
        ];
    }

    public function productPurchasePayload(): array
    {
        return [
            'kind' => 'androidpublisher#productPurchase',
            'purchaseTimeMillis' => '1678886400000',
            'purchaseState' => 0,
            'consumptionState' => 0,
            'developerPayload' => 'sample developer payload',
            'orderId' => 'GPA.1234-5678-9012-34567',
            'purchaseType' => 0,
            'acknowledgementState' => 0,
            'productId' => 'com.example.app.productId',
            'purchaseToken' => 'purchase token',
            'quantity' => 1,
            'refundableQuantity' => 1,
            'regionCode' => 'US',
            'obfuscatedExternalAccountId' => 'obfuscated external account id',
            'obfuscatedExternalProfileId' => 'obfuscated external profile id',
        ];
    }

    public function googleCredentials(): array
    {
        return [
            'type' => 'service_account',
            'project_id' => 'project-id-123456',
            'private_key_id' => '0123456789abcdef0123456789abcdef01234567',
            'private_key' => "-----BEGIN PRIVATE KEY-----\nfake-private-key\n-----END PRIVATE KEY-----\n",
            'client_email' => 'fake@project-id-123456.iam.gserviceaccount.com',
            'client_id' => '012345678901234567890',
            'auth_uri' => 'https://accounts.google.com/o/oauth2/auth',
            'token_uri' => 'https://oauth2.googleapis.com/token',
            'auth_provider_x509_cert_url' => 'https://www.googleapis.com/oauth2/v1/certs',
            'client_x509_cert_url' => 'https://www.googleapis.com/robot/v1/metadata/x509/fake%40project-id-123456.iam.gserviceaccount.com',
        ];
    }

    public function cloudMessage(array $data): array
    {
        return [
            'message' => [
                'data' => base64_encode(json_encode($data, JSON_PARTIAL_OUTPUT_ON_ERROR)),
                'messageId' => '136969346945',
            ],
            'subscription' => 'projects/myproject/subscriptions/mysubscription',
        ];
    }

    public function testNotificationPayload(): array
    {
        return [
            'version' => '1.0',
            'packageName' => 'com.some.app',
            'eventTimeMillis' => '1503349566168',
            'testNotification' => [
                'version' => '1.0',
            ],
        ];
    }

    public function voidedPurchaseNotificationPayload(): array
    {
        return [
            'version' => '1.0',
            'packageName' => 'com.some.app',
            'eventTimeMillis' => '1503349566168',
            'voidedPurchaseNotification' => [
                'purchaseToken' => 'PURCHASE_TOKEN',
                'orderId' => 'GS.0000-0000-0000',
                'productType' => 1,
                'refundType' => 1,
            ],
        ];
    }

    public function oneTimeProductNotificationPayload(): array
    {
        return [
            'version' => '1.0',
            'packageName' => 'com.some.thing',
            'eventTimeMillis' => '1503349566168',
            'oneTimeProductNotification' => [
                'version' => '1.0',
                'notificationType' => 1,
                'purchaseToken' => 'PURCHASE_TOKEN',
                'sku' => 'my.sku',
            ],
        ];
    }

    public function subscriptionNotificationPayload(): array
    {
        return [
            'version' => '1.0',
            'packageName' => 'com.some.thing',
            'eventTimeMillis' => '1503349566168',
            'subscriptionNotification' => [
                'version' => '1.0',
                'notificationType' => 4,
                'purchaseToken' => 'PURCHASE_TOKEN',
            ],
        ];
    }
}
