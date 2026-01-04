<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Domain\Purchase\ProductService;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ProductServiceTest extends TestCase
{
    #[Test]
    public function acknowledge(): void
    {
        $packageName = 'com.some.thing';
        $productId = 'com.some.thing.inapp1';
        $token = $this->faker->productToken();
        $history = [];
        $client = $this->mockClient([new Response()], $history);
        $sut = new ProductService(client: $client, normalizer: $this->normalizer, serializer: $this->serializer);

        $sut->acknowledge(packageName: $packageName, productId: $productId, token: $token);

        $this->assertClientSentRequest(
            history: $history,
            request: new Request(
                method: 'POST',
                uri: 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/com.some.thing/purchases/products/com.some.thing.inapp1/tokens/'.$token.':acknowledge',
                headers: [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                body: '{}',
            ),
        );
    }

    #[Test]
    public function acknowledge_with_developer_payload(): void
    {
        $packageName = 'com.some.thing';
        $productId = 'com.some.thing.inapp1';
        $token = $this->faker->productToken();
        $history = [];
        $client = $this->mockClient([new Response()], $history);
        $sut = new ProductService(client: $client, normalizer: $this->normalizer, serializer: $this->serializer);

        $sut->acknowledge(
            packageName: $packageName,
            productId: $productId,
            token: $token,
            developerPayload: 'payload_for_the_purchase',
        );

        $this->assertClientSentRequest(
            history: $history,
            request: new Request(
                method: 'POST',
                uri: 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/com.some.thing/purchases/products/com.some.thing.inapp1/tokens/'.$token.':acknowledge',
                headers: [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                body: '{"developerPayload":"payload_for_the_purchase"}',
            ),
        );
    }

    #[Test]
    public function consume(): void
    {
        $packageName = 'com.some.thing';
        $productId = 'com.some.thing.inapp1';
        $token = $this->faker->productToken();
        $history = [];
        $client = $this->mockClient([new Response()], $history);
        $sut = new ProductService(client: $client, normalizer: $this->normalizer, serializer: $this->serializer);

        $sut->consume(packageName: $packageName, productId: $productId, token: $token);

        $this->assertClientSentRequest(
            history: $history,
            request: new Request(
                method: 'POST',
                uri: 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/com.some.thing/purchases/products/com.some.thing.inapp1/tokens/'.$token.':consume',
                headers: [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
            ),
        );
    }

    #[Test]
    public function get(): void
    {
        $history = [];
        $packageName = 'com.example.app';
        $productId = 'com.example.app.product1';
        $token = $this->faker->productToken();
        $client = $this->mockClient($this->faker->productPurchaseResponse(), $history);
        $sut = new ProductService(client: $client, normalizer: $this->normalizer, serializer: $this->serializer);

        $sut->get(packageName: $packageName, productId: $productId, token: $token);

        $this->assertClientSentRequest(
            history: $history,
            request: new Request(
                method: 'GET',
                uri: 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/com.example.app/purchases/products/com.example.app.product1/tokens/'.$token,
                headers: [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
            ),
        );
    }
}
