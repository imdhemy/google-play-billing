<?php

declare(strict_types=1);

namespace Tests\AAA;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class FakerTest extends TestCase
{
    #[Test]
    public function it_registers_focused_fixture_providers_and_documents_them_as_mixins(): void
    {
        $expectedProviders = [
            GoogleAuthProvider::class,
            MonetizationProvider::class,
            PurchaseProvider::class,
            RtdnProvider::class,
        ];

        $docBlock = (new ReflectionClass(Faker::class))->getDocComment();

        $this->assertIsString($docBlock);
        $this->assertStringNotContainsString('DomainProvider', $docBlock);

        foreach ($expectedProviders as $provider) {
            $providerName = substr($provider, strrpos($provider, '\\') + 1);

            $this->assertTrue(class_exists($provider), sprintf('%s should exist.', $providerName));
            $this->assertStringContainsString(sprintf('@mixin %s', $providerName), $docBlock);
        }

        $faker = Faker::create();

        $this->assertIsArray($faker->googleCredentials());
        $this->assertIsArray($faker->productPurchasePayload());
        $this->assertIsArray($faker->testNotificationPayload());
        $this->assertIsArray($faker->convertRegionPricesResponseBody());
    }
}
