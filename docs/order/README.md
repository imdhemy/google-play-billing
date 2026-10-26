# Orders

The [Orders API](https://developers.google.com/android-publisher/api-ref/rest/v3/orders) manages one-time purchase and
subscription orders by their order ID. Each operation is a separate action that receives a request object.

## Refund an order

Use `RefundOrder` to refund a user's subscription or in-app purchase order. Orders older than three years cannot be
refunded.

```php
use Imdhemy\GooglePlay\Infrastructure\Http\ClientFactory;
use Imdhemy\GooglePlay\Order\Refund\RefundOrder;
use Imdhemy\GooglePlay\Order\Refund\RefundOrderRequest;

$refundOrder = new RefundOrder(ClientFactory::create());

$refundOrder->execute(new RefundOrderRequest(
    packageName: 'com.example.app',
    orderId: 'GPA.1234-5678-9012-34567',
));
```

Pass `revoke: true` to also revoke the purchased item. Access to the subscription or in-app item ends immediately, and
a recurring subscription stops renewing. Consumed in-app items still need to be handled by your app.

```php
$refundOrder->execute(new RefundOrderRequest(
    packageName: 'com.example.app',
    orderId: 'GPA.1234-5678-9012-34567',
    revoke: true,
));
```

A successful refund returns nothing. If Google Play answers with an unsuccessful status, `execute()` throws
`Imdhemy\GooglePlay\Exception\UnexpectedResponseException`, which exposes the request and the response:

```php
use Imdhemy\GooglePlay\Exception\UnexpectedResponseException;

try {
    $refundOrder->execute(new RefundOrderRequest(packageName: 'com.example.app', orderId: 'GPA.1234-5678-9012-34567'));
} catch (UnexpectedResponseException $exception) {
    $errorBody = (string) $exception->getResponse()->getBody();
}
```
