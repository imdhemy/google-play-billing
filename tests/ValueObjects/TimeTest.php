<?php

namespace Tests\ValueObjects;

use DateTime;
use DateTimeInterface;
use Imdhemy\GooglePlay\ValueObjects\Time;
use Tests\TestCase;

class TimeTest extends TestCase
{
    public function test_it_can_be_constructed_from_time_millis(): void
    {
        $millis = $this->faker->dateTimeBetween('+1 day', '+1 year')->getTimestamp() * 1000;

        $time = new Time($millis);

        $this->assertInstanceOf(Time::class, $time);
    }

    public function test_it_can_check_if_is_future(): void
    {
        $futureMillis = $this->faker->dateTimeBetween('+1 day', '+1 year')->getTimestamp() * 1000;

        $time = new Time($futureMillis);

        $this->assertTrue($time->isFuture());
    }

    public function test_is_can_check_if_is_past(): void
    {
        $pastMillis = $this->faker->dateTimeBetween('-1 year', '-1 day')->getTimestamp() * 1000;

        $time = new Time($pastMillis);

        $this->assertTrue($time->isPast());
    }

    public function to_date_time(): void
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
