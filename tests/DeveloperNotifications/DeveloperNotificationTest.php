<?php

namespace Imdhemy\GooglePlay\Tests\DeveloperNotifications;

use Imdhemy\GooglePlay\DeveloperNotifications\DeveloperNotification;
use Imdhemy\GooglePlay\DeveloperNotifications\SubscriptionNotification;
use Imdhemy\GooglePlay\Tests\TestCase;

class DeveloperNotificationTest extends TestCase
{
    /**
     * @test
     */
    public function test_it_can_be_constructed_from_encoded_string()
    {
        $data = 'eyJ2ZXJzaW9uIjoiMS4wIiwicGFja2FnZU5hbWUiOiJjb20udHdpZ2Fuby5mYXNoaW9uIiwiZXZlbnRUaW1lTWlsbGlzIjoiMTYwMzA1MTQxMjc5MSIsInN1YnNjcmlwdGlvbk5vdGlmaWNhdGlvbiI6eyJ2ZXJzaW9uIjoiMS4wIiwibm90aWZpY2F0aW9uVHlwZSI6MTMsInB1cmNoYXNlVG9rZW4iOiJla25kYmJmb2dpa2NnbHBpZGxmYmdpbHAuQU8tSjFPekFuSWpBaHVDY1lBc0Y2QU9xcEdVdU1JSXF5NHVpdndoV0hxSlplZXByMkZIWDUzVXpKRHBJUG4tREczWkVQZi1WUW5vWnV4R3VMQ3N5WlZidjd6Qmd0OEtNdHciLCJzdWJzY3JpcHRpb25JZCI6IndlZWtfcHJlbWl1bSJ9fQ==';
        $notification = DeveloperNotification::parse($data);
        $this->assertInstanceOf(DeveloperNotification::class, $notification);
    }

    /**
     * @test
     */
    public function test_it_can_be_converted_into_subscription_notification()
    {
        $data = 'eyJ2ZXJzaW9uIjoiMS4wIiwicGFja2FnZU5hbWUiOiJjb20udHdpZ2Fuby5mYXNoaW9uIiwiZXZlbnRUaW1lTWlsbGlzIjoiMTYwMzA1MTQxMjc5MSIsInN1YnNjcmlwdGlvbk5vdGlmaWNhdGlvbiI6eyJ2ZXJzaW9uIjoiMS4wIiwibm90aWZpY2F0aW9uVHlwZSI6MTMsInB1cmNoYXNlVG9rZW4iOiJla25kYmJmb2dpa2NnbHBpZGxmYmdpbHAuQU8tSjFPekFuSWpBaHVDY1lBc0Y2QU9xcEdVdU1JSXF5NHVpdndoV0hxSlplZXByMkZIWDUzVXpKRHBJUG4tREczWkVQZi1WUW5vWnV4R3VMQ3N5WlZidjd6Qmd0OEtNdHciLCJzdWJzY3JpcHRpb25JZCI6IndlZWtfcHJlbWl1bSJ9fQ==';
        $notification = DeveloperNotification::parse($data);
        $this->assertInstanceOf(SubscriptionNotification::class, $notification->getSubscriptionNotification());
    }
}
