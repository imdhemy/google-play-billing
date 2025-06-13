<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Transformer;

use Imdhemy\GooglePlay\Infrastructure\Transformer\Serializer;
use Tests\TestCase;

final class SerializerTest extends TestCase
{
    /** @test */
    public function serialize(): void
    {
        $data = Component::create('testComponent');
        $sut = Serializer::create();

        $actual = $sut->serialize($data);

        $expected = $this->jsonEncode([
            'name' => 'testComponent',
            'composedComponent' => [
                'name' => 'testComponent',
            ],
            'skippedComponent' => null,
        ]);
        $this->assertSame($expected, $actual);
    }
}

final readonly class Component
{
    public function __construct(
        public string $name,
        public ?ComposedComponent $composedComponent = null,
        public ?ComposedComponent $skippedComponent = null,
    ) {
    }

    public static function create(string $name): self
    {
        $composedComponent = new ComposedComponent($name);

        return new self(
            name: $name,
            composedComponent: $composedComponent,
        );
    }
}

final readonly class ComposedComponent
{
    public function __construct(
        public string $name,
    ) {
    }
}
