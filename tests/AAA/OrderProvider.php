<?php

declare(strict_types=1);

namespace Tests\AAA;

use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;

/**
 * Serves the `orders.get` fixture in `tests/assets/order/order.json`.
 *
 * Every payload method reads from the same decoded fixture, so the full response stays the only source of order data.
 */
final class OrderProvider
{
    private const string FIXTURE = __DIR__.'/../assets/order/order.json';

    /**
     * @var array<string, mixed>|null
     */
    private ?array $payload = null;

    /**
     * The fixture exactly as stored, for tests that check the raw response body.
     */
    public function orderResponseBody(): string
    {
        return (string)file_get_contents(self::FIXTURE);
    }

    public function orderResponse(): ResponseInterface
    {
        return new Response(
            status: 200,
            headers: ['Content-Type' => 'application/json'],
            body: $this->orderResponseBody(),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function orderPayload(): array
    {
        if (null === $this->payload) {
            /** @var array<string, mixed> $payload */
            $payload = json_decode($this->orderResponseBody(), true, flags: JSON_THROW_ON_ERROR);
            $this->payload = $payload;
        }

        return $this->payload;
    }

    /**
     * @return array<string, mixed>
     */
    public function buyerAddressPayload(): array
    {
        return $this->arrayAt($this->orderPayload(), 'buyerAddress');
    }

    /**
     * @return array<string, mixed>
     */
    public function orderDetailsPayload(): array
    {
        return $this->arrayAt($this->orderPayload(), 'orderDetails');
    }

    /**
     * @return array<string, mixed>
     */
    public function orderHistoryPayload(): array
    {
        return $this->arrayAt($this->orderPayload(), 'orderHistory');
    }

    /**
     * @return array<string, mixed>
     */
    public function processedEventPayload(): array
    {
        return $this->arrayAt($this->orderHistoryPayload(), 'processedEvent');
    }

    /**
     * @return array<string, mixed>
     */
    public function cancellationEventPayload(): array
    {
        return $this->arrayAt($this->orderHistoryPayload(), 'cancellationEvent');
    }

    /**
     * @return array<string, mixed>
     */
    public function refundEventPayload(): array
    {
        return $this->arrayAt($this->orderHistoryPayload(), 'refundEvent');
    }

    /**
     * @return array<string, mixed>
     */
    public function refundDetailsPayload(): array
    {
        return $this->arrayAt($this->refundEventPayload(), 'refundDetails');
    }

    /**
     * @return array<string, mixed>
     */
    public function partialRefundEventPayload(): array
    {
        return $this->arrayAt($this->arrayAt($this->orderHistoryPayload(), 'partialRefundEvents'), 0);
    }

    /**
     * @param string $productId The line item to select: monthly001, yearly001, weekly001 and premium001 are
     *                          subscriptions (free trial, base, introductory and proration phases), coins is a
     *                          one-time purchase and com.example.app is a paid app
     *
     * @return array<string, mixed>
     */
    public function lineItemPayload(string $productId = 'monthly001'): array
    {
        /** @var list<array<string, mixed>> $lineItems */
        $lineItems = $this->arrayAt($this->orderPayload(), 'lineItems');

        foreach ($lineItems as $lineItem) {
            if (($lineItem['productId'] ?? null) === $productId) {
                return $lineItem;
            }
        }

        throw new InvalidArgumentException(sprintf('The order fixture has no line item for %s.', $productId));
    }

    /**
     * @return array<string, mixed>
     */
    public function subscriptionDetailsPayload(string $productId = 'monthly001'): array
    {
        return $this->arrayAt($this->lineItemPayload($productId), 'subscriptionDetails');
    }

    /**
     * @return array<string, mixed>
     */
    public function offerPhaseDetailsPayload(string $productId = 'monthly001'): array
    {
        return $this->arrayAt($this->subscriptionDetailsPayload($productId), 'offerPhaseDetails');
    }

    /**
     * @return array<string, mixed>
     */
    public function freeTrialDetailsPayload(): array
    {
        return $this->arrayAt($this->offerPhaseDetailsPayload('monthly001'), 'freeTrialDetails');
    }

    /**
     * @return array<string, mixed>
     */
    public function baseDetailsPayload(): array
    {
        return $this->arrayAt($this->offerPhaseDetailsPayload('yearly001'), 'baseDetails');
    }

    /**
     * @return array<string, mixed>
     */
    public function introductoryPriceDetailsPayload(): array
    {
        return $this->arrayAt($this->offerPhaseDetailsPayload('weekly001'), 'introductoryPriceDetails');
    }

    /**
     * @return array<string, mixed>
     */
    public function prorationPeriodDetailsPayload(): array
    {
        return $this->arrayAt($this->offerPhaseDetailsPayload('premium001'), 'prorationPeriodDetails');
    }

    /**
     * @return array<string, mixed>
     */
    public function oneTimePurchaseDetailsPayload(): array
    {
        return $this->arrayAt($this->lineItemPayload('coins'), 'oneTimePurchaseDetails');
    }

    /**
     * @return array<string, mixed>
     */
    public function rentalDetailsPayload(): array
    {
        return $this->arrayAt($this->oneTimePurchaseDetailsPayload(), 'rentalDetails');
    }

    /**
     * @return array<string, mixed>
     */
    public function preorderDetailsPayload(): array
    {
        return $this->arrayAt($this->oneTimePurchaseDetailsPayload(), 'preorderDetails');
    }

    /**
     * @return array<string, mixed>
     */
    public function paidAppDetailsPayload(): array
    {
        return $this->arrayAt($this->lineItemPayload('com.example.app'), 'paidAppDetails');
    }

    /**
     * @return array<string, mixed>
     */
    public function pointsDetailsPayload(): array
    {
        return $this->arrayAt($this->orderPayload(), 'pointsDetails');
    }

    /**
     * @param array<array-key, mixed> $data
     *
     * @return array<string, mixed>
     */
    private function arrayAt(array $data, int|string $key): array
    {
        $value = $data[$key] ?? null;

        if (! is_array($value)) {
            throw new InvalidArgumentException(sprintf('The order fixture has no object at "%s".', $key));
        }

        /** @var array<string, mixed> $object */
        $object = $value;

        return $object;
    }
}
