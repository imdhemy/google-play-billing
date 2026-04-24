<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Transformer;

use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Infrastructure\Transformer\Normalizer;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class NormalizerTest extends TestCase
{
    #[Test]
    public function it_normalizes_arrays_into_objects(): void
    {
        $data = ['name' => $this->faker->name()];

        $instance = Normalizer::create()->normalize($data, MyValueObject::class);

        $this->assertInstanceOf(MyValueObject::class, $instance);
        $this->assertEquals($data['name'], $instance->name);
    }

    #[Test]
    public function it_normalizes_backed_enum_values(): void
    {
        $instance = Normalizer::create()->normalize(1, BackedEnumExample::class);

        $this->assertInstanceOf(BackedEnumExample::class, $instance);
        $this->assertEquals(1, $instance->value);
    }

    #[Test]
    public function it_normalizes_response_bodies_into_objects(): void
    {
        $data = ['name' => $this->faker->name()];
        $response = new Response(body: json_encode($data, JSON_PARTIAL_OUTPUT_ON_ERROR));

        $instance = Normalizer::create()->normalize($response, MyValueObject::class);

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

enum BackedEnumExample: int
{
    case ONE = 1;
    case TWO = 2;
}
