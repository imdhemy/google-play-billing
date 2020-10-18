<?php

namespace Imdhemy\GooglePlay\Tests\Subscriptions;

use Imdhemy\GooglePlay\Subscriptions\SubscriptionNotification;
use Imdhemy\GooglePlay\Tests\TestCase;

class SubscriptionNotificationTest extends TestCase
{
    /**
     * @test
     */
    public function test_it_can_be_constructed_from_encoded_string()
    {
        $jwt = 'eyJ2ZXJzaW9uIjoiMS4wIiwicGFja2FnZU5hbWUiOiJjb20udHdpZ2Fuby5mYXNoaW9uIiwiZXZlbnRUaW1lTWlsbGlzIjoiMTYwMzA1MTQxMjc5MSIsInN1YnNjcmlwdGlvbk5vdGlmaWNhdGlvbiI6eyJ2ZXJzaW9uIjoiMS4wIiwibm90aWZpY2F0aW9uVHlwZSI6MTMsInB1cmNoYXNlVG9rZW4iOiJla25kYmJmb2dpa2NnbHBpZGxmYmdpbHAuQU8tSjFPekFuSWpBaHVDY1lBc0Y2QU9xcEdVdU1JSXF5NHVpdndoV0hxSlplZXByMkZIWDUzVXpKRHBJUG4tREczWkVQZi1WUW5vWnV4R3VMQ3N5WlZidjd6Qmd0OEtNdHciLCJzdWJzY3JpcHRpb25JZCI6IndlZWtfcHJlbWl1bSJ9fQ==';
        $notification = SubscriptionNotification::parse($jwt);
        $this->assertInstanceOf(SubscriptionNotification::class, $notification);
    }
}
