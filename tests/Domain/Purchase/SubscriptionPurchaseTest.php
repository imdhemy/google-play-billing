<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase;

use Imdhemy\GooglePlay\Domain\Purchase\SubscriptionPurchase;
use Imdhemy\GooglePlay\ValueObjects\ExternalAccountIdentifiers;
use Imdhemy\GooglePlay\ValueObjects\SubscribeWithGoogleInfo;
use Imdhemy\GooglePlay\ValueObjects\SubscriptionAcknowledgementState;
use Imdhemy\GooglePlay\ValueObjects\SubscriptionPurchaseLineItem;
use Imdhemy\GooglePlay\ValueObjects\SubscriptionState;
use Tests\TestCase;

final class SubscriptionPurchaseTest extends TestCase
{
    /** @test */
    public function instantiation(): void
    {
        $data = [
            'kind' => 'androidpublisher#subscriptionPurchaseV2',
            'regionCode' => $this->faker->countryCode(),
            'lineItems' => [
                [
                    'productId' => $this->faker->word(),
                    'expiryTime' => '2014-10-02T15:01:23Z',
                    'latestSuccessfulOrderId' => $this->faker->uuid(),
                    'prepaidPlan' => [
                        'allowExtendAfterTime' => '2014-10-02T15:01:23Z',
                    ],
                    'offerDetails' => [
                        'offerTags' => [$this->faker->word()],
                        'basePlanId' => $this->faker->word(),
                        'offerId' => $this->faker->word(),
                    ],
                    'deferredItemReplacement' => [
                        'productId' => $this->faker->word(),
                    ],
                ],
            ],
            'startTime' => '2014-10-02T15:01:23Z',
            'subscriptionState' => $this->randomEnumValue(SubscriptionState::class),
            'linkedPurchaseToken' => $this->faker->uuid(),
            'pausedStateContext' => ['autoResumeTime' => '2014-10-02T15:01:23Z'],
            'canceledStateContext' => ['systemInitiatedCancellation' => []],
            'testPurchase' => [],
            'acknowledgementState' => $this->randomEnumValue(enumClass: SubscriptionAcknowledgementState::class),
            'externalAccountIdentifiers' => [
                'externalAccountId' => $this->faker->uuid(),
                'obfuscatedExternalAccountId' => $this->faker->uuid(),
                'obfuscatedExternalProfileId' => $this->faker->uuid(),
            ],
            'subscribeWithGoogleInfo' => [
                'profileId' => $this->faker->uuid(),
                'profileName' => $this->faker->name(),
                'emailAddress' => $this->faker->email(),
                'givenName' => $this->faker->firstName(),
                'familyName' => $this->faker->lastName(),
            ],
        ];

        $actual = $this->normalizer->normalize($data, SubscriptionPurchase::class);

        $this->assertSame($data['kind'], $actual->kind);
        $this->assertSame($data['regionCode'], $actual->regionCode);
        $this->assertInstanceOf(SubscriptionPurchaseLineItem::class, $actual->lineItems[0]);
        $this->assertEquals($data['startTime'], $actual->startTime?->originalValue);
        $this->assertEquals($data['subscriptionState'], $actual->subscriptionState->value);
        $this->assertSame($data['linkedPurchaseToken'], $actual->linkedPurchaseToken);
        $this->assertSame('2014-10-02T15:01:23Z', $actual->pausedStateContext?->autoResumeTime?->originalValue);
        $this->assertNotNull($actual->canceledStateContext->systemInitiatedCancellation);
        $this->assertNotNull($actual->testPurchase);
        $this->assertSame($data['acknowledgementState'], $actual->acknowledgementState->value);
        $this->assertEquals(
            new ExternalAccountIdentifiers(
                $data['externalAccountIdentifiers']['externalAccountId'],
                $data['externalAccountIdentifiers']['obfuscatedExternalAccountId'],
                $data['externalAccountIdentifiers']['obfuscatedExternalProfileId']
            ),
            $actual->externalAccountIdentifiers
        );
        $this->assertEquals(
            new SubscribeWithGoogleInfo(
                $data['subscribeWithGoogleInfo']['profileId'],
                $data['subscribeWithGoogleInfo']['profileName'],
                $data['subscribeWithGoogleInfo']['emailAddress'],
                $data['subscribeWithGoogleInfo']['givenName'],
                $data['subscribeWithGoogleInfo']['familyName']
            ),
            $actual->subscribeWithGoogleInfo
        );
    }
}
