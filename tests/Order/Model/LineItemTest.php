<?php

declare(strict_types=1);

namespace Tests\Order\Model;

use GuzzleHttp\Psr7\Response;
use Imdhemy\GooglePlay\Order\Model\LineItem;
use Imdhemy\GooglePlay\Order\Model\OneTimePurchaseDetails;
use Imdhemy\GooglePlay\Order\Model\PaidAppDetails;
use Imdhemy\GooglePlay\Order\Model\SubscriptionDetails;
use Imdhemy\GooglePlay\ValueObjects\Money;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class LineItemTest extends TestCase
{
    #[Test]
    public function it_normalizes_a_subscription_line_item(): void
    {
        $response = new Response(body: '{"productTitle":"Monthly plan","productId":"monthly001","listingPrice":{"currencyCode":"EUR","units":"9","nanos":990000000},"total":{"currencyCode":"EUR","units":"9","nanos":990000000},"tax":{"currencyCode":"EUR","units":"1","nanos":730000000},"subscriptionDetails":{"basePlanId":"monthly"}}');

        $lineItem = $this->normalizer->normalize(data: $response, type: LineItem::class);

        $this->assertEquals(new LineItem(
            productTitle: 'Monthly plan',
            productId: 'monthly001',
            listingPrice: new Money('EUR', '9', 990000000),
            total: new Money('EUR', '9', 990000000),
            tax: new Money('EUR', '1', 730000000),
            subscriptionDetails: new SubscriptionDetails(basePlanId: 'monthly'),
        ), $lineItem);
    }

    #[Test]
    public function it_normalizes_a_one_time_purchase_line_item(): void
    {
        $response = new Response(body: '{"productId":"coins","oneTimePurchaseDetails":{"quantity":3}}');

        $lineItem = $this->normalizer->normalize(data: $response, type: LineItem::class);

        $this->assertEquals(new LineItem(productId: 'coins', oneTimePurchaseDetails: new OneTimePurchaseDetails(quantity: 3)), $lineItem);
    }

    #[Test]
    public function it_normalizes_a_paid_app_line_item(): void
    {
        $response = new Response(body: '{"productId":"com.example.app","paidAppDetails":{}}');

        $lineItem = $this->normalizer->normalize(data: $response, type: LineItem::class);

        $this->assertEquals(new LineItem(productId: 'com.example.app', paidAppDetails: new PaidAppDetails()), $lineItem);
    }

    #[Test]
    public function it_leaves_fields_the_response_omits_as_null(): void
    {
        $response = new Response(body: '{}');

        $lineItem = $this->normalizer->normalize(data: $response, type: LineItem::class);

        $this->assertEquals(new LineItem(), $lineItem);
    }
}
