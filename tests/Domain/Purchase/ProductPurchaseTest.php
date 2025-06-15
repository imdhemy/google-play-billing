<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase;

use Imdhemy\GooglePlay\Domain\Purchase\ProductPurchase;
use Tests\TestCase;

final class ProductPurchaseTest extends TestCase
{
    /** @test */
    public function instantiation(): void
    {
        $data = $this->faker->productPurchasePayload();

        $actual = $this->normalizer->normalize($data, ProductPurchase::class);

        $this->assertInstanceOf(ProductPurchase::class, $actual);
        $this->assertSame($data['kind'], $actual->kind);
        $this->assertSame($data['purchaseTimeMillis'], $actual->purchaseTimeMillis->originalValue);
        $this->assertSame($data['purchaseState'], $actual->purchaseState->value);
        $this->assertSame($data['consumptionState'], $actual->consumptionState->value);
        $this->assertSame($data['developerPayload'], $actual->developerPayload);
        $this->assertSame($data['orderId'], $actual->orderId);
        $this->assertSame($data['purchaseType'], $actual->purchaseType->value);
        $this->assertSame($data['acknowledgementState'], $actual->acknowledgementState->value);
        $this->assertSame($data['purchaseToken'], $actual->purchaseToken);
        $this->assertSame($data['productId'], $actual->productId);
        $this->assertSame($data['quantity'], $actual->quantity);
        $this->assertSame($data['obfuscatedExternalAccountId'], $actual->obfuscatedExternalAccountId);
        $this->assertSame($data['obfuscatedExternalProfileId'], $actual->obfuscatedExternalProfileId);
        $this->assertSame($data['regionCode'], $actual->regionCode);
        $this->assertSame($data['refundableQuantity'], $actual->refundableQuantity);
    }
}
