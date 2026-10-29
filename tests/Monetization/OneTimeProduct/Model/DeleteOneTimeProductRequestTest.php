<?php

declare(strict_types=1);

namespace Tests\Monetization\OneTimeProduct\Model;

use Imdhemy\GooglePlay\Monetization\OneTimeProduct\Model\DeleteOneTimeProductRequest;
use Imdhemy\GooglePlay\ValueObjects\ProductUpdateLatencyTolerance;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class DeleteOneTimeProductRequestTest extends TestCase
{
    #[Test]
    public function it_serializes_the_request_body(): void
    {
        $request = new DeleteOneTimeProductRequest(
            packageName: 'com.example.app',
            productId: 'premium_upgrade',
            latencyTolerance: ProductUpdateLatencyTolerance::TOLERANT,
        );

        $result = $request->jsonSerialize();

        $this->assertSame([
            'packageName' => 'com.example.app',
            'productId' => 'premium_upgrade',
            'latencyTolerance' => 'PRODUCT_UPDATE_LATENCY_TOLERANCE_LATENCY_TOLERANT',
        ], $result);
    }

    #[Test]
    public function it_omits_the_latency_tolerance_when_not_set(): void
    {
        $request = new DeleteOneTimeProductRequest(
            packageName: 'com.example.app',
            productId: 'premium_upgrade',
        );

        $result = $request->jsonSerialize();

        $this->assertSame([
            'packageName' => 'com.example.app',
            'productId' => 'premium_upgrade',
        ], $result);
    }
}
