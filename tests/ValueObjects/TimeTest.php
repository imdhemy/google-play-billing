<?php

namespace Tests\ValueObjects;

use DateTime;
use DateTimeInterface;
use Imdhemy\GooglePlay\ValueObjects\Time;
use Tests\TestCase;

class TimeTest extends TestCase
{
    /**
     * @test
     */
    public function test_it_can_be_constructed_from_time_millis()
    {
        $millis = $this->faker->dateTimeBetween('+1 day', '+1 year')->getTimestamp() * 1000;

        $time = new Time($millis);

        $this->assertInstanceOf(Time::class, $time);
    }

    /**
     * @test
     */
    public function test_it_can_check_if_is_future()
    {
        $futureMillis = $this->faker->dateTimeBetween('+1 day', '+1 year')->getTimestamp() * 1000;

        $time = new Time($futureMillis);

        $this->assertTrue($time->isFuture());
    }

    /**
     * @test
     */
    public function test_is_can_check_if_is_past()
    {
        $pastMillis = $this->faker->dateTimeBetween('-1 year', '-1 day')->getTimestamp() * 1000;

        $time = new Time($pastMillis);

        $this->assertTrue($time->isPast());
    }

    /**
     * @test
     */
    public function to_date_time()
    {
        $dateTime = new DateTime();
        $timeMillis = strtotime($dateTime->format(DateTimeInterface::ATOM)) * 1000;

        $time = new Time($timeMillis);
        $this->assertInstanceOf(DateTime::class, $time->toDateTime());
        $this->assertEquals(
            $dateTime->format(DateTimeInterface::ATOM),
            $time->toDateTime()->format(DateTimeInterface::ATOM)
        );
    }
}
