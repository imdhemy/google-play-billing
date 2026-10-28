# Stateless actions for new domains

Date: 2026-10-27
Status: direction chosen

## Hypothesis

Domain namespaces and separate stateless actions make ownership explicit and allow operations to evolve independently.
New domains will follow this direction, using the [Orders discussion](https://github.com/imdhemy/google-play-billing/issues/334#issuecomment-6421436757)
as the concrete example.

## Direction chosen

Each operation has its own action and fully named request class. Responses containing data have action-specific wrappers;
empty responses return `void`. For example:

```text
src/
├── ValueObjects/
│   └── Money.php
└── Order/
    ├── Model/
    │   ├── Order.php
    │   └── …order-specific child models
    ├── Get/
    │   ├── GetOrder.php
    │   ├── GetOrderRequest.php
    │   └── GetOrderResponse.php
    ├── BatchGet/
    │   ├── BatchGetOrders.php
    │   ├── BatchGetOrdersRequest.php
    │   └── BatchGetOrdersResponse.php
    ├── Refund/
    │   ├── RefundOrder.php
    │   └── RefundOrderRequest.php
    └── ReviewRefund/
        ├── ReviewOrderRefund.php
        └── ReviewOrderRefundRequest.php
```

Domain-specific models belong in the domain's `Model` namespace. Shared types listed under Google's Types section,
such as `Money`, stay in `ValueObjects`.

Each action owns HTTP mapping and conversion, receiving the client, serializer, and normalizer only as needed.
`Infrastructure\Http\ClientFactory` supplies the PSR-18 client. Actions explicitly check unsuccessful responses with
`UnexpectedResponseException::assertSuccessfulResponse()`. Transport and conversion exceptions propagate unchanged.

## What we expect

Operations can be contributed independently, with focused dependencies and no requirement to implement retrieval before
other operations. We defer a single `OrderService` entry point until usage provides a reason for it.

This direction guides new domains. Migrating existing domains is outside this decision, and the example above describes
the intended structure rather than a record of completed implementation.
