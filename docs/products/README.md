# One-time purchase lifecycle

This document explains how to process one-time purchases in your backend. You can find more information about the cycle
in the [official documentation](https://developer.android.com/google/play/billing/lifecycle/one-time).

## Real-time developer notifications (RTDN)

> [!NOTE]
> Note: One-time purchase real-time developer notifications are only published if you have [opted into them while
> configuring real-time developer notifications](https://developer.android.com/google/play/billing/getting-ready#enable-rtdn).

When a user purchases or cancels the purchase of a one-time product, Google Play sends a [
`OneTimeProductNotification`](https://developer.android.com/google/play/billing/rtdn-reference#one-time) message. You
can parse it as follows:

```php
use Imdhemy\GooglePlay\Infrastructure\Transformer\Normalizer;
use Imdhemy\GooglePlay\Interface\Rtdn\NotificationParser;

// Create a notification parser
$normalizer = Normalizer::create();
$notificationParser = new NotificationParser($normalizer);

// Send the payload of the RTDN message to the parser as an array
$message = $notificationParser->parse($rtdnMessage);

// Access the OneTimeProductNotification from the parsed message
$notification = $message->oneTimeProductNotification;
```

### Handle completed transactions

When a user completes a one-time product purchase, Google Play sends a `OneTimeProductNotification` message with the
type `ONE_TIME_PRODUCT_PURCHASED`. When you receive this RTDN, process the purchase as described
in [Process one-time product purchases below](#process-one-time-product-purchases-in-your-backend).

```php
use Imdhemy\GooglePlay\Domain\Rtdn\Notification\OneTimeProductNotification;
use Imdhemy\GooglePlay\Domain\Rtdn\Type\OneTimeProductNotificationType;

/** @var OneTimeProductNotification $notification */
if(OneTimeProductNotificationType::PURCHASED === $notification->notificationType) {
 // process the purchase
}
```

### Handle canceled transactions

When a one-time product purchase is canceled, Google Play sends a `OneTimeProductNotification` message with the type
`ONE_TIME_PRODUCT_CANCELED` if you have configured to receive real-time developer notifications. For example, this can
occur if the user doesn't complete payment within the required timeframe, or if the purchase is revoked by the developer
or by customer request. When your backend server receives this notification, call the `purchases.products.get` method to
get the latest purchase state, then update your backend accordingly, including user entitlements.

If a one-time product purchase in Purchased state gets refunded, you will also be made aware via the Voided Purchases
API.

```php
use Imdhemy\GooglePlay\Domain\Rtdn\Notification\OneTimeProductNotification;
use Imdhemy\GooglePlay\Domain\Rtdn\Type\OneTimeProductNotificationType;

/** @var OneTimeProductNotification $notification */
if(OneTimeProductNotificationType::CANCELED === $notification->notificationType) {
    // Get the purchase token and the product ID from the notification
    $purchaseToken = $notification->purchaseToken;
    $productId = $notification->sku;
    
    // Call the purchases.products.get method (described below) to get the latest purchase state
}
```

## Process one-time product purchases in your backend

Processing one-time product purchases in your backend is recommended for better security. Follow these steps to process
a new one-time product purchase:

Query the `purchases.products.get` endpoint to obtain the latest one-time product purchase status. To call this
method for a purchase, you need the corresponding purchaseToken either from your app or from the
`ONE_TIME_PRODUCT_PURCHASED` RTDN.

Then, [verify the purchase state](https://developer.android.com/google/play/billing/security#verify).

Finally, give the user access to the content. The user account associated with the purchase can be identified with the
`obfuscatedExternalAccountId` field from purchases.products.get, if one was set using [
`setObfuscatedAccountId()`](https://developer.android.com/reference/com/android/billingclient/api/BillingFlowParams.Builder#setObfuscatedAccountId(java.lang.String))
when the purchase was made.

```php
use Imdhemy\GooglePlay\Domain\Purchase\Product\PurchaseState;use Imdhemy\GooglePlay\Domain\Purchase\ProductService;use Imdhemy\GooglePlay\Infrastructure\Http\ClientFactory;
use Imdhemy\GooglePlay\Infrastructure\Transformer\Normalizer;
use Imdhemy\GooglePlay\Infrastructure\Transformer\Serializer;
use Imdhemy\GooglePlay\Domain\Rtdn\Notification\OneTimeProductNotification;

$client = ClientFactory::create();
$normalizer = Normalizer::create();
$serializer = Serializer::create();

$productsService = new ProductService($client, $normalizer, $serializer);

$productPurchase = $productsService->get($packageName, $productId, $purchaseToken);

// Make sure the purchase is in the PURCHASED state
if(PurchaseState::PURCHASED === $productPurchase->purchaseState) {
 // Verify the purchase state
 // ...
 
 // Get the obfuscated external account ID if it was set
  $obfuscatedExternalAccountId = $productPurchase->obfuscatedExternalAccountId;
}
```

### Acknowledge non-consumable product purchases

For non-consumable product purchases, acknowledge delivery of the content by calling the
`purchases.products.acknowledge` method. Make sure that the purchase hasn't been previously acknowledged by checking the
`acknowledgementState` field.

```php
use Imdhemy\GooglePlay\Domain\Purchase\Entity\ProductPurchase;
use Imdhemy\GooglePlay\Domain\Purchase\Product\AcknowledgementState;
use Imdhemy\GooglePlay\Domain\Purchase\ProductService;

/** @var ProductPurchase $productPurchase  */
/** @var ProductService $productsService  */

if(AcknowledgementState::NOT_ACKNOWLEDGED === $productPurchase->acknowledgementState) {
    // acknowledge the purchase
    $productsService->acknowledge($packageName, $productPurchase->productId, $productPurchase->purchaseToken);
}

```

### Consuming one-time products

If the product is consumable, mark the item as consumed by calling the `purchases.products.consume` method so that the
user can buy the item again after they have consumed it. This method also acknowledges the purchase.

```php
use Imdhemy\GooglePlay\Domain\Purchase\Entity\ProductPurchase;
use Imdhemy\GooglePlay\Domain\Purchase\Product\ConsumptionState;use Imdhemy\GooglePlay\Domain\Purchase\ProductService;

/** @var ProductPurchase $productPurchase  */
/** @var ProductService $productsService  */


if(ConsumptionState::NOT_CONSUMED === $productPurchase->consumptionState){
    // consume the purchase
    $productsService->consume($packageName, $productPurchase->productId, $productPurchase->purchaseToken);
}
```

> [!NOTE]
> Note: If you don't acknowledge a purchase within three days, the user automatically receives a refund, and Google Play
> revokes the purchase.
