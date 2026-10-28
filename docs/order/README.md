# Orders

The [Orders API](https://developers.google.com/android-publisher/api-ref/rest/v3/orders) manages one-time purchase and
subscription orders by their order ID. Each operation is a separate action that receives a request object.

## Review a refund request

When a user asks for a refund, Google Play can send a pending refund review notification. Use `ReviewRefundOrder` to
answer it with your refund preference and information about how the purchase was used. See
[orders.reviewrefund](https://developers.google.com/android-publisher/api-ref/rest/v3/orders/reviewrefund).

```php
use Imdhemy\GooglePlay\Infrastructure\Http\ClientFactory;
use Imdhemy\GooglePlay\Infrastructure\Transformer\Serializer;
use Imdhemy\GooglePlay\Order\Model\RefundPreference;
use Imdhemy\GooglePlay\Order\ReviewRefund\ReviewRefundOrder;
use Imdhemy\GooglePlay\Order\ReviewRefund\ReviewRefundOrderRequest;

$reviewRefundOrder = new ReviewRefundOrder(ClientFactory::create(), Serializer::create());

$reviewRefundOrder->execute(new ReviewRefundOrderRequest(
    packageName: 'com.example.app',
    orderId: 'GPA.1234-5678-9012-34567',
    pendingRefundToken: $pendingRefundToken, // from the pending refund review notification
    sampleContentProvided: false,
    refundPreference: RefundPreference::DECLINE,
));
```

`refundPreference` accepts `RefundPreference::APPROVE`, `RefundPreference::DECLINE`, or `RefundPreference::NEUTRAL`.

You can also report how much of the purchase was consumed. `consumptionPercentageMilliunits` ranges from 0 to 100,000
(45200 means 45.2%), and you can send at most 1,000 `ConsumptionUsageEvent` objects. Values outside these limits throw
an `InvalidArgumentException` before the request is sent.

```php
use Imdhemy\GooglePlay\Order\Model\CoarseLocation;
use Imdhemy\GooglePlay\Order\Model\ConsumptionUsageEvent;

$reviewRefundOrder->execute(new ReviewRefundOrderRequest(
    packageName: 'com.example.app',
    orderId: 'GPA.1234-5678-9012-34567',
    pendingRefundToken: $pendingRefundToken,
    sampleContentProvided: true,
    refundPreference: RefundPreference::DECLINE,
    consumptionPercentageMilliunits: 45200,
    consumptionUsageEvents: [
        new ConsumptionUsageEvent(
            obfuscatedAccountId: $obfuscatedAccountId,
            consumptionTime: '2014-10-02T15:01:23Z',
            consumptionItemDescription: 'Watched episode 3',
            location: new CoarseLocation(regionCode: 'ES'),
        ),
    ],
));
```

A successful review returns nothing. If Google Play answers with an unsuccessful status, `execute()` throws
`Imdhemy\GooglePlay\Exception\UnexpectedResponseException`, which exposes the request and the response.
