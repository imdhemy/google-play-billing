<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Http;

use Imdhemy\GooglePlay\Infrastructure\Http\ClientFactory;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ClientFactoryTest extends TestCase
{
    #[Test]
    public function create(): void
    {
        $this->expectNotToPerformAssertions();

        ClientFactory::create();
    }

    #[Test]
    public function create_with_credentials(): void
    {
        $this->expectNotToPerformAssertions();

        $credentials = $this->faker->googleCredentials();

        ClientFactory::create($credentials);
    }
}
