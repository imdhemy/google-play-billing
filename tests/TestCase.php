<?php

namespace Tests;

use Faker\Factory;
use Faker\Generator;
use Imdhemy\GooglePlay\Normalizer\Normalizer;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected Generator $faker;
    protected Normalizer $normalizer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
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
}
