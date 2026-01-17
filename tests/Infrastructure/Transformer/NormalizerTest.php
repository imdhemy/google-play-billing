<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Transformer;

use Imdhemy\GooglePlay\Infrastructure\Transformer\Normalizer;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Tests\TestCase;

final class NormalizerTest extends TestCase
{
    #[Test]
    public function convert(): void
    {
        $data = ['name' => $this->faker->name()];

        $instance = Normalizer::create()->normalize($data, MyValueObject::class);

        $this->assertInstanceOf(MyValueObject::class, $instance);
        $this->assertEquals($data['name'], $instance->name);
    }

    #[Test]
    public function it_supports_backed_enums(): void
    {
        $instance = Normalizer::create()->normalize(1, BackedEnumExample::class);

        $this->assertInstanceOf(BackedEnumExample::class, $instance);
        $this->assertEquals(1, $instance->value);
    }

    #[Test]
    #[AllowMockObjectsWithoutExpectations]
    public function it_normalizes_from_response_interface(): void
    {
        $data = ['name' => $this->faker->name()];
        $body = json_encode($data, JSON_PARTIAL_OUTPUT_ON_ERROR);
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getBody')->willReturn($this->createMock(StreamInterface::class));
        /** @var MockObject $stream */
        $stream = $response->getBody();
        $stream->method('getContents')->willReturn($body);

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
