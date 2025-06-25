# Upgrade from 1.x to 2.0

- All `Imdhemy\GooglePlay\DeveloperNotifications` namespace classes should be replaced with
  `\Imdhemy\GooglePlay\Domain\Rtdn` namespace classes.
- Replace the usage of `\Imdhemy\GooglePlay\Products\ProductClient` with
  `\Imdhemy\GooglePlay\Domain\Purchase\ProductService`
- Replace the usage of `\Imdhemy\GooglePlay\Subscriptions\SubscriptionClient` with
  `\Imdhemy\GooglePlay\Domain\Purchase\SubscriptionService`
- Replace the usage of `\Imdhemy\GooglePlay\ClientFactory` with `\Imdhemy\GooglePlay\Infrastructure\Http\ClientFactory`
