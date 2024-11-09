<?php

declare(strict_types=1);

namespace Tests\Normalizer;

use Imdhemy\GooglePlay\Normalizer\Normalizer;
use Tests\TestCase;

final class NormalizerTest extends TestCase
{
    /** @test */
    public function convert(): void
    {
        $data = ['name' => $this->faker->name()];

        $instance = Normalizer::create()->normalize($data, MyValueObject::class);

        $this->assertInstanceOf(MyValueObject::class, $instance);
        $this->assertEquals($data['name'], $instance->name);
    }
}

final readonly class MyValueObject
{
    public function __construct(public string $name)
    {
    }
}
