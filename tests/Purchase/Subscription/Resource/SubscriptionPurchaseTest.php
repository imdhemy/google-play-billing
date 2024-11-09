<?php

declare(strict_types=1);

namespace Tests\Purchase\Subscription\Resource;

use Imdhemy\GooglePlay\Purchase\Subscription\Resource\SubscriptionPurchase;
use Imdhemy\GooglePlay\Serializer;
use Tests\TestCase;

final class SubscriptionPurchaseTest extends TestCase
{
    /** @test */
    public function create(): void
    {
        $data = [
            'kind' => 'androidpublisher#subscriptionPurchaseV2',
            'regionCode' => $this->faker->countryCode(),
        ];

        $actual = Serializer::create()->deserialize(
            $this->jsonEncode($data),
            SubscriptionPurchase::class
        );

        $this->assertSame($data['kind'], $actual->kind);
        $this->assertSame($data['regionCode'], $actual->regionCode);
    }
}
