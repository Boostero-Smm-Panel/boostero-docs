# Boostero API

Reference and runnable examples for the Boostero API v2, the HTTP interface behind
[boostero.com](https://boostero.com). Full reference: <https://boostero.com/api>

Everything below was checked against the live endpoint. Where a number is measured
rather than published, the date and the method are given with it.

## Contents

- [Base URL and authentication](#base-url-and-authentication)
- [There are no webhooks. Status is polled.](#there-are-no-webhooks-status-is-polled)
- [Request rate](#request-rate)
- [Methods](#methods)
- [Errors](#errors)
- [Code examples](#code-examples)
- [Security](#security)

## Base URL and authentication

```
https://boostero.com/api/v2
```

All requests are `POST` with form-encoded parameters. Every request carries two fields:

| Parameter | Description |
|---|---|
| `key` | Your API key, from the Account page of your panel |
| `action` | The method to call, exactly as spelled below, lower case |

There are no other authentication mechanisms: no OAuth, no bearer token, no signed
request. The key is the credential, so treat it as one (see [Security](#security)).

## There are no webhooks. Status is polled.

No webhooks. Order status is polled, up to 100 IDs per request.

This is a property of Perfect Panel, the software this panel runs on, not a Boostero
limitation: the specification has no webhook, callback or push mechanism in any of its
ten calls. Measured 2026-09-11 against the Perfect Panel demo API and nine other panels
running the same script, eight of which serve a byte-identical copy of the same
response example.

It is cheaper to work around than it first looks, because `status` accepts up to
**100 order IDs in a single request**:

- Keep a local set of order IDs that are not yet in a final state.
- Poll that set in batches of up to 100, not one call per order.
- Space the batches about one second apart.
- Drop an order from the set as soon as it is `Completed` or `Canceled`. Those do not
  change again, and polling them is pure waste.
- Back off when nothing is moving. An order that has not changed in an hour does not
  need a check every second.

A reseller with a thousand open orders needs ten requests per polling cycle, not a
thousand.

## Request rate

No per-key or per-IP limit is published, and responses carry no rate limit headers.

**Measured on 4 September 2026:** 170 sequential requests sent at roughly nine per
second all returned HTTP 200, with no throttling, no error, and no measurable slowdown
across the run.

What degrades is concurrency, not rate. Twenty-five simultaneous requests all
succeeded, but the slowest took 2.5 seconds against about 100 milliseconds for the same
calls sent one after another. So: send sequentially, keep in-flight requests in single
figures, and batch order IDs.

These figures describe what the endpoint did on the date measured. They are not a
service commitment. If your integration depends on a specific ceiling, open a ticket
and ask rather than inferring one from a benchmark.

## Methods

Ten calls. Each is `POST https://boostero.com/api/v2` with `key` and `action`.

| Action | `action` value | Distinguishing parameter |
|---|---|---|
| [Service list](#service-list) | `services` | none |
| [Add order](#add-order) | `add` | `service`, `link`, `quantity` |
| [Order status](#order-status) | `status` | `order` |
| [Multiple order status](#multiple-order-status) | `status` | `orders` (up to 100) |
| [Create refill](#create-refill) | `refill` | `order` |
| [Create multiple refill](#create-multiple-refill) | `refill` | `orders` (up to 100) |
| [Refill status](#refill-status) | `refill_status` | `refill` |
| [Multiple refill status](#multiple-refill-status) | `refill_status` | `refills` (up to 100) |
| [Cancel](#cancel) | `cancel` | `orders` (up to 100) |
| [Balance](#balance) | `balance` | none |

Note that `status`, `refill` and `refill_status` each cover both the single and the
batch case. Which one you get depends on whether you send the singular parameter
(`order`, `refill`) or the plural one (`orders`, `refills`).

### Service list

| Parameter | Description |
|---|---|
| `key` | Your API key |
| `action` | `services` |

```bash
curl -X POST https://boostero.com/api/v2 \
  -d "key=YOUR_API_KEY" \
  -d "action=services"
```

```json
[
    {
        "service": 1,
        "name": "Followers",
        "type": "Default",
        "category": "First Category",
        "rate": "0.90",
        "min": "50",
        "max": "10000",
        "refill": true,
        "cancel": true
    }
]
```

`rate` is the price per 1000 units. An order costs `rate * quantity / 1000`. The
`refill` and `cancel` booleans tell you which services accept those actions; requesting
one on a service that does not support it returns an error rather than doing nothing.

### Add order

| Parameter | Description |
|---|---|
| `key` | Your API key |
| `action` | `add` |
| `service` | Service ID |
| `link` | Link to page |
| `quantity` | Needed quantity |
| `runs` (optional) | Runs to deliver |
| `interval` (optional) | Interval in minutes |

```bash
curl -X POST https://boostero.com/api/v2 \
  -d "key=YOUR_API_KEY" \
  -d "action=add" \
  -d "service=1" \
  -d "link=https://example.com/your-profile" \
  -d "quantity=100"
```

```json
{
    "order": 23501
}
```

`runs` and `interval` together are drip-feed: the quantity is delivered in `runs`
batches, `interval` minutes apart. The charge is multiplied by `runs`, so a drip-feed
order of 100 across 5 runs delivers 500 units and costs five times a single run.

The parameter set above is the Default order type. The `add` action also accepts other
order types, each with its own parameters: Package, Custom Comments, Mentions Custom
List, Mentions Hashtag, Mentions User Followers, Comment Likes, Poll, and
Subscriptions. Their parameter tables are on <https://boostero.com/api> and are not
reproduced here, because a parameter list that drifts out of date is worse than a link
to the current one.

### Order status

| Parameter | Description |
|---|---|
| `key` | Your API key |
| `action` | `status` |
| `order` | Order ID |

```bash
curl -X POST https://boostero.com/api/v2 \
  -d "key=YOUR_API_KEY" \
  -d "action=status" \
  -d "order=12345"
```

```json
{
    "charge": "0.27819",
    "start_count": "3572",
    "status": "Partial",
    "remains": "157",
    "currency": "USD"
}
```

### Multiple order status

| Parameter | Description |
|---|---|
| `key` | Your API key |
| `action` | `status` |
| `orders` | Order IDs, comma separated, up to 100 |

```bash
curl -X POST https://boostero.com/api/v2 \
  -d "key=YOUR_API_KEY" \
  -d "action=status" \
  -d "orders=1,10,100"
```

```json
{
    "1": {
        "charge": "0.27819",
        "start_count": "3572",
        "status": "Partial",
        "remains": "157",
        "currency": "USD"
    },
    "10": {
        "error": "Incorrect order ID"
    }
}
```

The response is an object keyed by order ID, and each entry carries either its own
result or its own error. A partial failure is normal: one bad ID does not fail the
request, and the other IDs still resolve. Parse per entry, not per response.

This is the call that makes the absence of webhooks manageable. One request covers a
hundred orders.

### Create refill

| Parameter | Description |
|---|---|
| `key` | Your API key |
| `action` | `refill` |
| `order` | Order ID |

```bash
curl -X POST https://boostero.com/api/v2 \
  -d "key=YOUR_API_KEY" \
  -d "action=refill" \
  -d "order=12345"
```

```json
{
    "refill": "1"
}
```

The returned value is a refill ID. Keep it: it is what `refill_status` takes.

### Create multiple refill

| Parameter | Description |
|---|---|
| `key` | Your API key |
| `action` | `refill` |
| `orders` | Order IDs, comma separated, up to 100 |

```bash
curl -X POST https://boostero.com/api/v2 \
  -d "key=YOUR_API_KEY" \
  -d "action=refill" \
  -d "orders=1,2,3"
```

```json
[
    {
        "order": 1,
        "refill": 1
    },
    {
        "order": 2,
        "refill": 2
    },
    {
        "order": 3,
        "refill": {
            "error": "Incorrect order ID"
        }
    }
]
```

An array here, not an object, and the per-item error sits inside `refill` rather than
beside it.

### Refill status

| Parameter | Description |
|---|---|
| `key` | Your API key |
| `action` | `refill_status` |
| `refill` | Refill ID |

```bash
curl -X POST https://boostero.com/api/v2 \
  -d "key=YOUR_API_KEY" \
  -d "action=refill_status" \
  -d "refill=1"
```

```json
{
    "status": "Completed"
}
```

### Multiple refill status

| Parameter | Description |
|---|---|
| `key` | Your API key |
| `action` | `refill_status` |
| `refills` | Refill IDs, comma separated, up to 100 |

```bash
curl -X POST https://boostero.com/api/v2 \
  -d "key=YOUR_API_KEY" \
  -d "action=refill_status" \
  -d "refills=1,2,3"
```

```json
[
    {
        "refill": 1,
        "status": "Completed"
    },
    {
        "refill": 2,
        "status": "Rejected"
    },
    {
        "refill": 3,
        "status": {
            "error": "Refill not found"
        }
    }
]
```

### Cancel

| Parameter | Description |
|---|---|
| `key` | Your API key |
| `action` | `cancel` |
| `orders` | Order IDs, comma separated, up to 100 |

```bash
curl -X POST https://boostero.com/api/v2 \
  -d "key=YOUR_API_KEY" \
  -d "action=cancel" \
  -d "orders=2,9"
```

```json
[
    {
        "order": 9,
        "cancel": {
            "error": "Incorrect order ID"
        }
    },
    {
        "order": 2,
        "cancel": 1
    }
]
```

There is no single-order form of `cancel`; send one ID in `orders`. Cancel is only
available on services whose `cancel` flag is true in the service list.

### Balance

| Parameter | Description |
|---|---|
| `key` | Your API key |
| `action` | `balance` |

```bash
curl -X POST https://boostero.com/api/v2 \
  -d "key=YOUR_API_KEY" \
  -d "action=balance"
```

```json
{
    "balance": "100.84292",
    "currency": "USD"
}
```

## Errors

Errors arrive as JSON with an `error` key.

**The HTTP status is not uniform, and a handler that only checks status codes misses
most errors.** Authentication failures come back as 401 and an unknown action as 404,
but every validation failure comes back as **HTTP 200** with the error in the body.
Check both: reading only the status code hides every validation error, and reading only
the body hides a rejected key.

| Error | HTTP | What it means | What to do |
|---|---|---|---|
| `Invalid API key` | 401 | The key is missing, mistyped, or has been regenerated since you stored it. | Copy the current key from the Account page. Do not retry with the same value. |
| `Incorrect request` | 404 | No action was sent, or the action name is not one this API knows. | Check the action against the method reference above. Spelling is exact and lower case. |
| `Incorrect request` | 200 | The action is valid but a parameter it requires was not sent. | Compare your request against the parameter table for that action. |
| `Incorrect order ID` | 200 | No order with that ID exists on your account. Order IDs are scoped to the account that placed them. | Confirm the ID came from an `add` response on this key. In a batched call the error is returned per ID, so the other IDs still resolve. |
| `Incorrect service ID` | 200 | No service with that ID, or the service is no longer available. Also returned when `add` is called with no parameters at all. | Refresh your cached service list. IDs change when services are retired or replaced. |
| `Quantity less than minimal N` | 200 | The quantity is below the service minimum. The message carries the actual minimum in place of N. | Read `min` from the service list and validate before sending. The number in the message is the value to use. |
| `Quantity more than maximum N` | 200 | The quantity is above the service maximum. The message carries the actual maximum in place of N. | Read `max` from the service list. For a larger volume, split across several orders or use drip-feed. |
| `Not enough funds on balance` | 200 | The order cost exceeds your available balance. Cost is `rate * quantity / 1000`, multiplied again by `runs` for drip-feed. | Top up, or reduce the quantity. Calling `balance` before a batch is cheaper than handling this error mid-run. |

### Which check fires first

The endpoint returns one error, not a list, so a request that is wrong in several ways
reports only the first failure. The order was measured on 4 September 2026 by sending
requests deliberately wrong in several ways at once:

1. **Service ID.** An unknown service is rejected before anything else is looked at.
2. **Quantity range.** A request with a bad quantity, a bad link and a cost over
   balance returns the quantity error.
3. **Balance.** A request with a bad link and no funds returns the funds error.

The practical consequence when debugging: fixing the error you were shown can reveal
another underneath it. Validate quantity against `min` and `max` on your side and the
second round trip disappears.

### The link is not validated

There is no fourth check. Once the service exists, the quantity is in range and the
balance covers the cost, the order is created and the link is taken as given.

**Tested on 4 September 2026: the literal string `notaurl` was accepted as a link and
returned an order ID rather than an error.**

This is the single most useful thing to know before writing an integration against this
endpoint. A typo in a link does not come back as an error you can catch. It comes back
as an order ID, the balance is charged, and the order fails later at the provider,
where your code is no longer watching.

Validate links on your side before sending them: check that the URL parses, that the
host matches the platform the service targets, and that it is a profile link where the
service needs a profile and a post link where it needs a post. Nothing downstream will
do it for you.

## Code examples

Runnable, not fragments. Each one places a request, checks for the `error` key and
raises on it, then calls services, balance, add and status.

| File | Language |
|---|---|
| [example.php](example.php) | PHP with curl |
| [example.py](example.py) | Python with requests |
| [example.js](example.js) | Node.js with fetch |
| [curl-examples.md](curl-examples.md) | Terminal quick reference |

Replace `YOUR_API_KEY` with the key from your account panel.

These files are mirrored from
<https://gitlab.com/boostero-smm-panel-group/Boostero-Smm-Panel-project>, which is
where they are maintained. They are kept byte-identical rather than rewritten, so the
two repositories cannot drift apart.

## Security

- Store the key in an environment variable or a secrets manager. Never in source code,
  and never in a file that reaches version control.
- Never put the key in anything that runs in a browser or ships inside a mobile app.
  Every request must originate from your server.
- Use one key per system. If a key has to be replaced you then replace one integration
  rather than all of them at once.
- Rotate on suspicion rather than on schedule. A key that has appeared in a screenshot,
  a support thread, a log file or a shared terminal is already exposed.
- Regenerating on the Account page invalidates the previous key immediately, so plan
  the swap before you press it.

## Questions

See [faq.md](faq.md) for refill, sandbox, reselling, and how the API compares to a
child panel.

## Links

- Full API reference: <https://boostero.com/api>
- Panel: <https://boostero.com>
- Examples repository (upstream):
  <https://gitlab.com/boostero-smm-panel-group/Boostero-Smm-Panel-project>

## Licence

MIT. See [LICENSE](LICENSE).
