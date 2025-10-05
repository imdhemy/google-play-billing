<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Entity;

use Imdhemy\GooglePlay\Domain\Purchase\Entity\SubscriptionPurchase;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\AcknowledgementState;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\ExternalAccountIdentifiers;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\SubscribeWithGoogleInfo;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\SubscriptionPurchaseLineItem;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\SubscriptionState;
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
            'acknowledgementState' => $this->randomEnumValue(enumClass: AcknowledgementState::class),
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

    /** @test */
    public function instantiation_with_required_fields(): void
    {
        $data = [
            'kind' => 'androidpublisher#subscriptionPurchaseV2',
            'regionCode' => $this->faker->countryCode(),
            'subscriptionState' => $this->randomEnumValue(SubscriptionState::class),
            'acknowledgementState' => $this->randomEnumValue(enumClass: AcknowledgementState::class),
        ];

        $actual = $this->normalizer->normalize($data, SubscriptionPurchase::class);

        $this->assertSame($data['kind'], $actual->kind);
        $this->assertSame($data['regionCode'], $actual->regionCode);
        $this->assertSame($data['subscriptionState'], $actual->subscriptionState->value);
        $this->assertSame($data['acknowledgementState'], $actual->acknowledgementState->value);
        $this->assertNull($actual->externalAccountIdentifiers);
        $this->assertNull($actual->subscribeWithGoogleInfo);
        $this->assertEmpty($actual->lineItems);
        $this->assertNull($actual->startTime);
        $this->assertNull($actual->linkedPurchaseToken);
        $this->assertNull($actual->pausedStateContext);
        $this->assertNull($actual->canceledStateContext);
        $this->assertNull($actual->testPurchase);
    }
}
