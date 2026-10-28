# Screaming architecture

Applies to: `src/**`, `tests/**`

Make domains and operations visible in directory names. Use domain-first namespaces with operation directories.

## Version scope

- Identify the target release before applying this rule.
- In `1.x`, apply it only to new domains. Preserve existing domain structure, including when adding operations.
- From `2.x` onward, apply it to all domains. Migrate nonmatching domains as part of major-version work, within the requested scope.

## Domain and operation structure

- Use a singular domain namespace, such as `Order`, with one directory per operation.
- Give each operation a stateless action and a fully named request class. Requests contain all caller-supplied path, query, and body values.
- Return an action-specific response wrapper when the response contains data. Successful empty responses return `void`.
- Put domain-specific models in the domain's `Model` namespace. Shared types listed under Google's Types section belong in `ValueObjects`.

```text
src/
├── ValueObjects/
│   └── Money.php
└── Order/
    ├── Model/
    │   └── Order.php
    ├── Get/
    │   ├── GetOrder.php
    │   ├── GetOrderRequest.php
    │   └── GetOrderResponse.php
    └── Refund/
        ├── RefundOrder.php
        └── RefundOrderRequest.php
```

This is the target structure, not a record of completed implementation. Align tests with their domain and operation.

## Action boundaries

- Each action owns HTTP mapping and conversion. Inject the client, serializer, and normalizer only as needed.
- Obtain the PSR-18 client through `Infrastructure\Http\ClientFactory`.
- Explicitly check HTTP responses with `UnexpectedResponseException::assertSuccessfulResponse()`; do not assume the client throws for unsuccessful status codes.
- Let transport and conversion exceptions propagate unchanged.
- Keep operations independently implementable. Defer a unified domain service or facade until usage justifies one.

See the [original design decision](../../docs/design-notebook/20261027T125038Z-stateless-actions-for-new-domains.md). The version scope above extends it to all domains in future major releases.
