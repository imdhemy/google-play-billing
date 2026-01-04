<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Transformer;

use Imdhemy\GooglePlay\Infrastructure\Transformer\Normalizer;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class NormalizerTest extends TestCase
{
    #[test]
    public function convert(): void
    {
        $data = ['name' => $this->faker->name()];

        $instance = Normalizer::create()->normalize($data, MyValueObject::class);

        $this->assertInstanceOf(MyValueObject::class, $instance);
        $this->assertEquals($data['name'], $instance->name);
    }

    #[test]
    public function it_supports_backed_enums(): void
    {
        $instance = Normalizer::create()->normalize(1, BackedEnumExample::class);

        $this->assertInstanceOf(BackedEnumExample::class, $instance);
        $this->assertEquals(1, $instance->value);
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
