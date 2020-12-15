<?php

namespace Imdhemy\GooglePlay\ValueObjects;

final class CancelSurveyReason
{
    private $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function other(): bool
    {
        return $this->value === 0;
    }

    public function doNotUseEnough(): bool
    {
        return $this->value === 1;
    }

    public function technical(): bool
    {
        return $this->value === 2;
    }

    public function cost(): bool
    {
        return $this->value === 3;
    }

    public function foundBetterApp(): bool
    {
        return $this->value === 4;
    }
}
