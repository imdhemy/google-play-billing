<?php

declare(strict_types=1);

namespace Tests\Monetization\OneTimeProduct;

use Imdhemy\GooglePlay\Monetization\OneTimeProduct\DeleteOneTimeProductRequest;
use Imdhemy\GooglePlay\ValueObjects\ProductUpdateLatencyTolerance;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class DeleteOneTimeProductRequestTest extends TestCase
{
    #[Test]
    public function instantiation(): void
    {
        $data = [
            'packageName' => 'com.example.app',
            'productId' => 'premium_upgrade',
            'latencyTolerance' => $this->randomEnumValue(ProductUpdateLatencyTolerance::class),
        ];

        $request = $this->normalizer->normalize($data, DeleteOneTimeProductRequest::class);

        $this->assertInstanceOf(DeleteOneTimeProductRequest::class, $request);
        $this->assertSame($data['packageName'], $request->packageName);
        $this->assertSame($data['productId'], $request->productId);
        $this->assertSame(ProductUpdateLatencyTolerance::from($data['latencyTolerance']), $request->latencyTolerance);
    }

    #[Test]
    public function latency_tolerance_is_optional(): void
    {
        $data = [
            'packageName' => 'com.example.app',
            'productId' => 'premium_upgrade',
        ];

        $request = $this->normalizer->normalize($data, DeleteOneTimeProductRequest::class);

        $this->assertNull($request->latencyTolerance);
    }

    #[Test]
    public function it_serializes_the_request_body(): void
    {
        $request = new DeleteOneTimeProductRequest(
            packageName: 'com.example.app',
            productId: 'premium_upgrade',
            latencyTolerance: ProductUpdateLatencyTolerance::TOLERANT,
        );

        $this->assertSame([
            'packageName' => 'com.example.app',
            'productId' => 'premium_upgrade',
            'latencyTolerance' => 'PRODUCT_UPDATE_LATENCY_TOLERANCE_LATENCY_TOLERANT',
        ], $request->jsonSerialize());
    }

    #[Test]
    public function it_omits_the_latency_tolerance_when_not_set(): void
    {
        $request = new DeleteOneTimeProductRequest(
            packageName: 'com.example.app',
            productId: 'premium_upgrade',
        );

        $this->assertSame([
            'packageName' => 'com.example.app',
            'productId' => 'premium_upgrade',
        ], $request->jsonSerialize());
    }
}
