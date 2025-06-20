<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Http;

use Imdhemy\GooglePlay\Infrastructure\Http\ClientFactory;
use Tests\TestCase;

final class ClientFactoryTest extends TestCase
{
    /** @test */
    public function create(): void
    {
        $this->expectNotToPerformAssertions();

        ClientFactory::create();
    }

    /** @test */
    public function create_with_credentials(): void
    {
        $this->expectNotToPerformAssertions();

        $credentials = $this->faker->googleCredentials();

        ClientFactory::create($credentials);
    }
}
