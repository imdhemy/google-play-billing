<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\ExternalAccountIdentifiers;
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
}
