<?php

declare(strict_types=1);

namespace Tests\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\Domain\Purchase\Subscription\UserInitiatedCancellation;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class UserInitiatedCancellationTest extends TestCase
{
    #[test]
    public function instantiation(): void
    {
        $data = [
            'cancelSurveyResult' => [
                'reason' => 'CANCEL_SURVEY_REASON_UNSPECIFIED',
            ],
            'cancelTime' => '2014-10-02T15:01:23Z',
        ];

        $actual = $this->normalizer->normalize($data, UserInitiatedCancellation::class);

        $this->assertInstanceOf(UserInitiatedCancellation::class, $actual);
        $this->assertSame($data['cancelTime'], $actual->cancelTime->originalValue);
    }
}
