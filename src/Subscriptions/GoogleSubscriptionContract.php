<?php

namespace Imdhemy\GooglePlay\Subscriptions;
use Imdhemy\GooglePlay\ValueObjects\V1\Time;

interface GoogleSubscriptionContract
{
    public function getKind(): ?string;

    public function getExpiryTime(): ?Time;



}