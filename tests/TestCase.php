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

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
    }
}
