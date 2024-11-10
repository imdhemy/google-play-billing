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

    protected function todo(string $message): void
    {
        $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1];

        $warning = sprintf(
            'Warning: %s in %s on line %d',
            $message,
            $caller['file'],
            $caller['line']
        );
        trigger_error($warning, E_USER_WARNING);
        
        $this->markTestIncomplete($message);
    }
}
