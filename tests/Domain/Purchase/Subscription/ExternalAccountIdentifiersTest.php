<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\Domain\Purchase\Subscription\ExternalAccountIdentifiers;
use Tests\TestCase;

final class ExternalAccountIdentifiersTest extends TestCase
{
    /** @test */
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

    /** @test */
    public function instantiation_without_external_account_id(): void
    {
        $data = [
            // externalAccountId and obfuscatedExternalProfileId are optional
            'obfuscatedExternalAccountId' => $this->faker->uuid(),
        ];

        $actual = $this->normalizer->normalize($data, ExternalAccountIdentifiers::class);

        $this->assertInstanceOf(ExternalAccountIdentifiers::class, $actual);
        $this->assertNull($actual->externalAccountId);
        $this->assertEquals($data['obfuscatedExternalAccountId'], $actual->obfuscatedExternalAccountId);
        $this->assertNull($actual->obfuscatedExternalProfileId);
    }
}
