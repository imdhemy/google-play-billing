<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\Domain\Purchase\Subscription\ExternalAccountIdentifiers;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ExternalAccountIdentifiersTest extends TestCase
{
    #[Test]
    public function instantiation(): void
    {
        $data = [
            'externalAccountId' => $this->faker->uuid(),
            'obfuscatedExternalAccountId' => $this->faker->uuid(),
            'obfuscatedExternalProfileId' => $this->faker->uuid(),
        ];

        $actual = $this->normalizer->normalize($data, ExternalAccountIdentifiers::class);

        $this->assertInstanceOf(ExternalAccountIdentifiers::class, $actual);
        $this->assertEquals($data['externalAccountId'], $actual->externalAccountId);
        $this->assertEquals($data['obfuscatedExternalAccountId'], $actual->obfuscatedExternalAccountId);
        $this->assertEquals($data['obfuscatedExternalProfileId'], $actual->obfuscatedExternalProfileId);
    }

    #[Test]
    public function instantiation_with_obfuscated_external_account_id_only(): void
    {
        $data = [
            'obfuscatedExternalAccountId' => $this->faker->uuid(),
        ];

        $actual = $this->normalizer->normalize($data, ExternalAccountIdentifiers::class);

        $this->assertInstanceOf(ExternalAccountIdentifiers::class, $actual);
        $this->assertNull($actual->externalAccountId);
        $this->assertEquals($data['obfuscatedExternalAccountId'], $actual->obfuscatedExternalAccountId);
        $this->assertNull($actual->obfuscatedExternalProfileId);
    }

    #[Test]
    public function instantiation_with_external_account_id_only(): void
    {
        $data = [
            'externalAccountId' => $this->faker->uuid(),
        ];

        $actual = $this->normalizer->normalize($data, ExternalAccountIdentifiers::class);

        $this->assertInstanceOf(ExternalAccountIdentifiers::class, $actual);
        $this->assertSame($data['externalAccountId'], $actual->externalAccountId);
        $this->assertNull($actual->obfuscatedExternalAccountId);
        $this->assertNull($actual->obfuscatedExternalProfileId);
    }

    #[Test]
    public function instantiation_with_obfuscated_external_profile_id_only(): void
    {
        $data = [
            'obfuscatedExternalProfileId' => $this->faker->uuid(),
        ];

        $actual = $this->normalizer->normalize($data, ExternalAccountIdentifiers::class);

        $this->assertInstanceOf(ExternalAccountIdentifiers::class, $actual);
        $this->assertNull($actual->externalAccountId);
        $this->assertNull($actual->obfuscatedExternalAccountId);
        $this->assertSame($data['obfuscatedExternalProfileId'], $actual->obfuscatedExternalProfileId);
    }

    #[Test]
    public function instantiation_with_no_identifiers(): void
    {
        $actual = $this->normalizer->normalize([], ExternalAccountIdentifiers::class);

        $this->assertInstanceOf(ExternalAccountIdentifiers::class, $actual);
        $this->assertNull($actual->externalAccountId);
        $this->assertNull($actual->obfuscatedExternalAccountId);
        $this->assertNull($actual->obfuscatedExternalProfileId);
    }
}
