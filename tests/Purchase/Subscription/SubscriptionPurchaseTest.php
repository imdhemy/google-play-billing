<?php

declare(strict_types=1);

namespace Tests\Purchase\Subscription;

use Imdhemy\GooglePlay\Purchase\Subscription\SubscriptionPurchase;
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
        ];

        $actual = $this->normalizer->normalize($data, SubscriptionPurchase::class);

        $this->assertSame($data['kind'], $actual->kind);
        $this->assertSame($data['regionCode'], $actual->regionCode);
        $this->assertInstanceOf(SubscriptionPurchaseLineItem::class, $actual->lineItems[0]);
        $this->assertEquals($data['startTime'], $actual->startTime?->originalValue);
        $this->assertEquals($data['subscriptionState'], $actual->subscriptionState->value);
        $this->assertSame($data['linkedPurchaseToken'], $actual->linkedPurchaseToken);
    }

    //    /** @test */
    //    public function instantiate_without_optional_params(): void
    //    {
    //    }
}
