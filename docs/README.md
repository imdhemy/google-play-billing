# PHP Google Play In-App Purchase (Google Play Billing)

Google Play's billing system provides a way to manage the most important aspects of your digital product business, from
setting up the catalog to tracking your transactions. This PHP package includes several services and helpers to keep
your backend in sync with the Google Play backend. In particular, the Subscriptions and in-app purchases API handles
functionality related to your digital product sales on Google Play.

> [!TIP]
> If you are using Laravel, you can use the [Laravel In-App Purchase](https://imdhemy.com/laravel-iap-docs/) instead,
> which is a wrapper around this package, and tailored for Laravel applications.

## Getting Started

Here is a basic example of how to use the package to verify a subscription purchase:

```php
use Imdhemy\GooglePlay\Domain\Purchase\SubscriptionService;
use Imdhemy\GooglePlay\Infrastructure\Http\ClientFactory;
use Imdhemy\GooglePlay\Infrastructure\Transformer\Normalizer;
use Imdhemy\GooglePlay\Infrastructure\Transformer\Serializer;

$client = ClientFactory::create();
$normalizer = Normalizer::create();
$serializer = Serializer::create();

// Create a subscription service instance
$subscriptionService = new SubscriptionService($client, $normalizer, $serializer);

// Get a subscription purchase v2 instance
$subscriptionPurchase = $subscriptionService->get('com.example.app', 'PURCHASE_TOKEN');
```

## Usage

For more detailed information on how to use the package:

* [x] [Client Authentication](./client-authentication.md).
* [X] [Product lifecycle](./products/README.md).
