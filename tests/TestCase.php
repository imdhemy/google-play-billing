<?php

namespace Tests;

use Faker\Factory;
use Faker\Generator;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Generator
     */
    protected $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    protected function jsonEncode(array $data): string
    {
        return json_encode($data, JSON_PARTIAL_OUTPUT_ON_ERROR);
    }
}
