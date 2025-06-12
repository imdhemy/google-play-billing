<?php

declare(strict_types=1);

namespace Tests;

use BackedEnum;
use Imdhemy\GooglePlay\Infrastructure\Normalizer\Normalizer;
use InvalidArgumentException;
use Tests\AAA\Faker;
use Tests\AAA\FakerFactory;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected Faker $faker;
    protected Normalizer $normalizer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = FakerFactory::create();
        $this->normalizer = Normalizer::create();
    }

    protected function jsonEncode(array $data): string
    {
        return json_encode($data, JSON_PARTIAL_OUTPUT_ON_ERROR);
    }

    protected function todo(string $message): void
    {
        $this->markTestIncomplete($message);
    }

    /**
     * @param class-string $enumClass
     */
    protected function randomEnumValue(string $enumClass): int|string
    {
        if (! is_subclass_of($enumClass, BackedEnum::class)) {
            throw new InvalidArgumentException(sprintf('The class %s must be a backed enum.', $enumClass));
        }

        $cases = $enumClass::cases();

        return $cases[array_rand($cases)]->value;
    }
}
