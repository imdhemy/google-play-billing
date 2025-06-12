<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\SubscribeWithGoogleInfo;
use Tests\TestCase;

final class SubscribeWithGoogleInfoTest extends TestCase
{
    /** @test */
    public function instantiation(): void
    {
        $data = [
            'profileId' => $this->faker->uuid(),
            'profileName' => $this->faker->name(),
            'emailAddress' => $this->faker->email(),
            'givenName' => $this->faker->firstName(),
            'familyName' => $this->faker->lastName(),
        ];

        $actual = $this->normalizer->normalize($data, SubscribeWithGoogleInfo::class);

        $this->assertInstanceOf(SubscribeWithGoogleInfo::class, $actual);
        $this->assertEquals($data['profileId'], $actual->profileId);
        $this->assertEquals($data['profileName'], $actual->profileName);
        $this->assertEquals($data['emailAddress'], $actual->emailAddress);
        $this->assertEquals($data['givenName'], $actual->givenName);
        $this->assertEquals($data['familyName'], $actual->familyName);
    }
}
