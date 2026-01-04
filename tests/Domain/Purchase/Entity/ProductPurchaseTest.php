<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Entity;

use Imdhemy\GooglePlay\Domain\Purchase\Entity\ProductPurchase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ProductPurchaseTest extends TestCase
{
    #[Test]
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

    #[Test]
    public function instantiation_with_required_fields(): void
    {
        $data = $this->faker->productPurchasePayload(
            omit: [
                'purchaseToken',
                'productId',
                'obfuscatedExternalAccountId',
                'obfuscatedExternalProfileId',
                'refundableQuantity',
            ]
        );

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
        $this->assertSame($data['quantity'], $actual->quantity);
        $this->assertSame($data['regionCode'], $actual->regionCode);
        $this->assertNull($actual->purchaseToken);
        $this->assertNull($actual->productId);
        $this->assertNull($actual->obfuscatedExternalAccountId);
        $this->assertNull($actual->obfuscatedExternalProfileId);
        $this->assertNull($actual->refundableQuantity);
    }
}
