<?php

namespace Imdhemy\GooglePlay\Tests\ValueObjects;

use Imdhemy\GooglePlay\Tests\TestCase;
use Imdhemy\GooglePlay\ValueObjects\AcknowledgementState;

class AcknowledgementStateTest extends TestCase
{
    /**
     * @test
     * @dataProvider stateDataProvider
     * @param $value
     * @param $result
     */
    public function test_isAcknowledged($value, $result)
    {
        $state = new AcknowledgementState($value);
        $this->assertEquals($result, $state->isAcknowledged());
    }

    public function stateDataProvider()
    {
        return [
            [1, true],
            [0, false],
        ];
    }
}
