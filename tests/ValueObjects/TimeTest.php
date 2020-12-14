<?php

namespace Imdhemy\GooglePlay\Tests\ValueObjects;

use Carbon\Carbon;
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

    /**
     * @test
     */
    public function test_fake()
    {
        $this->assertInstanceOf(Time::class, Time::fake());
    }

    /**
     * @test
     */
    public function test_fake_time_in_ranges()
    {
        $start = Carbon::create(2019, 12, 1, 13, 13, 13);
        $end = Carbon::create(2020, 12, 1, 13, 13, 13);
        $fakeTime = Time::fakeBetween($start->toDateTime(), $end->toDateTime());

        $this->assertTrue($start->lessThan($fakeTime->getCarbon()));
        $this->assertTrue($end->greaterThan($fakeTime->getCarbon()));
    }

    /**
     * @test
     */
    public function test_fake_time_after_the_specified_time()
    {
        $start = Carbon::now();
        $fakeTime = Time::fakeAfter($start->toDateTime());
        $this->assertTrue($fakeTime->getCarbon()->greaterThan($start));
    }

    /**
     * @test
     */
    public function test_fake_time_before_the_specified_time()
    {
        $end = Carbon::now();
        $fakeTime = Time::fakeBefore($end);
        $this->assertTrue($end->greaterThan($fakeTime->getCarbon()));
    }

    /**
     * @test
     */
    public function test_fake_future_time()
    {
        $this->assertTrue(Time::fakeFuture()->isFuture());
    }

    /**
     * @test
     */
    public function test_fake_past_time()
    {
        $this->assertTrue(Time::fakePast()->isPast());
    }
}
