<?php

declare(strict_types=1);

namespace Tests\Serializer;

use Imdhemy\GooglePlay\Serializer\DataConverter;
use Tests\TestCase;

final class DataConverterTest extends TestCase
{
    /** @test */
    public function convert(): void
    {
        $data = ['name' => $this->faker->name()];

        $instance = DataConverter::create()->convert($data, MyValueObject::class);

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
