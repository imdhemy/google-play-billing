<?php

namespace Tests\ValueObjects;

use Faker\Factory;
use Faker\Generator;
use Imdhemy\GooglePlay\ValueObjects\PaymentState;
use PHPUnit\Framework\TestCase;

class PaymentStateTest extends TestCase
{
    /**
     * @var Generator
     */
    private $faker;

    /**
     * @return array
     */
    public function stateProvider(): array
    {
        return [
            [PaymentState::PAYMENT_STATE_PENDING, 'isPending'],
            [PaymentState::PAYMENT_STATE_RECEIVED, 'isReceived'],
            [PaymentState::PAYMENT_STATE_FREE_TRIAL, 'isFreeTrial'],
            [PaymentState::PAYMENT_STATE_DEFERRED, 'isDeferred'],
        ];
    }

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    /**
     * @test
     */
    public function payment_state()
    {
        $value = $this->faker->randomElement([
            PaymentState::PAYMENT_STATE_PENDING,
            PaymentState::PAYMENT_STATE_RECEIVED,
            PaymentState::PAYMENT_STATE_FREE_TRIAL,
            PaymentState::PAYMENT_STATE_DEFERRED,
        ]);

        $paymentState = new PaymentState($value);

        $this->assertEquals($value, $paymentState->getValue());
    }

    /**
     * @test
     * @dataProvider stateProvider
     */
    public function state_checkers($value, $checker)
    {
        $paymentState = new PaymentState($value);
        $this->assertTrue($paymentState->$checker());
    }

    /**
     * @test
     */
    public function to_string()
    {
        $state = $this->faker->randomElement(
            range(PaymentState::PAYMENT_STATE_PENDING, PaymentState::PAYMENT_STATE_DEFERRED)
        );
        $paymentState = new PaymentState($state);

        $this->assertEquals($state, (string)$paymentState);
    }
}
