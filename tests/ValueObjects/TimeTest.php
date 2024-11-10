<?php

namespace Tests\ValueObjects;

use Imdhemy\GooglePlay\ValueObjects\Time;
use Tests\TestCase;

class TimeTest extends TestCase
{
    /** @test */
    public function create_from_time_millis(): void
    {
        $millis = $this->faker->dateTimeBetween('+1 day', '+1 year')->getTimestamp() * 1000;

        $time = new Time((string)$millis);

        $this->assertEquals($millis, $time->originalValue);
        $this->assertEquals($millis, $time->carbon->getTimestampMs());
        $this->assertTrue($time->isFuture());
        $this->assertFalse($time->isPast());
    }

    /** @test */
    public function create_from_zulu_timestamp(): void
    {
        $value = '2014-10-02T15:01:23.045123456Z';

        $time = new Time($value);

        $this->assertEquals($value, $time->originalValue);
        $this->assertEquals('2014-10-02 15:01:23', $time->carbon->toDateTimeString());
        $this->assertTrue($time->isPast());
        $this->assertFalse($time->isFuture());
    }
}
