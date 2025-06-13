<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\RevocationContext;
use Tests\TestCase;

final class RevocationContextTest extends TestCase
{
    /** @test */
    public function full_refund(): void
    {
        $actual = RevocationContext::forFullRefund();

        $this->assertNotNull($actual->fullRefund);
        $this->assertNull($actual->proratedRefund);
        $this->assertNull($actual->itemBasedRefund);
    }

    /** @test */
    public function prorated_refund(): void
    {
        $actual = RevocationContext::forProratedRefund();

        $this->assertNotNull($actual->proratedRefund);
        $this->assertNull($actual->fullRefund);
        $this->assertNull($actual->itemBasedRefund);
    }

    /** @test */
    public function item_based_refund(): void
    {
        $productId = $this->faker->word();

        $actual = RevocationContext::forItemBasedRefund($productId);

        $this->assertNotNull($actual->itemBasedRefund);
        $this->assertNull($actual->fullRefund);
        $this->assertNull($actual->proratedRefund);
        $this->assertEquals($productId, $actual->itemBasedRefund->productId);
    }

    /**
     * @test
     *
     * @dataProvider provide_objects_for_serialization
     */
    public function serialization(RevocationContext $value, string $expected): void
    {
        $actual = $this->serializer->serialize($value);

        $this->assertEquals($expected, $actual);
    }

    public static function provide_objects_for_serialization(): array
    {
        return [
            'full refund' => [
                RevocationContext::forFullRefund(),
                '{"fullRefund":{}}',
            ],
            'prorated refund' => [
                RevocationContext::forProratedRefund(),
                '{"proratedRefund":{}}',
            ],
            'item based refund' => [
                RevocationContext::forItemBasedRefund('test_product'),
                '{"itemBasedRefund":{"productId":"test_product"}}',
            ],
        ];
    }
}
