<?php

namespace Imdhemy\GooglePlay\Tests\ValueObjects;

use Imdhemy\GooglePlay\Tests\TestCase;
use Imdhemy\GooglePlay\ValueObjects\ConsumptionState;

class ConsumptionStateTest extends TestCase
{
    /**
     * @test
     * @dataProvider stateDataProvider
     * @param $value
     * @param $result
     */
    public function testIsConsumed($value, $result)
    {
        $consumptionState = new ConsumptionState($value);
        $this->assertEquals($result, $consumptionState->isConsumed());
    }

    public function stateDataProvider()
    {
        return [
            [0, false],
            [1, true],
        ];
    }
}
