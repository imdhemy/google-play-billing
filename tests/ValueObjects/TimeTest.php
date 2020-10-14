<?php

namespace Imdhemy\GooglePlay\Tests\ValueObjects;

use Faker\Factory;
use Imdhemy\GooglePlay\Tests\TestCase;
use Imdhemy\GooglePlay\ValueObjects\Time;

class TimeTest extends TestCase
{
    /**
     * @test
     */
    public function test_it_can_be_constructed_from_time_millis()
    {
        $faker = Factory::create();
        $millis = $faker->dateTimeBetween('+1 day', '+1 year')->getTimestamp() * 1000;

        $time = new Time($millis);

        $this->assertInstanceOf(Time::class, $time);
    }

    /**
     * @test
     */
    public function test_it_can_check_if_is_future()
    {
        $faker = Factory::create();
        $futureMillis = $faker->dateTimeBetween('+1 day', '+1 year')->getTimestamp() * 1000;

        $time = new Time($futureMillis);

        $this->assertTrue($time->isFuture());
    }

    /**
     * @test
     */
    public function test_is_can_check_if_is_past()
    {
        $faker = Factory::create();
        $pastMillis = $faker->dateTimeBetween('-1 year', '-1 day')->getTimestamp() * 1000;

        $time = new Time($pastMillis);

        $this->assertTrue($time->isPast());
    }
}
