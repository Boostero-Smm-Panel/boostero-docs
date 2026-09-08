# Boostero API FAQ

Questions about the API itself. Full reference: <https://boostero.com/api>

## Does the Boostero API support refill?

Yes. The API exposes refill for a single order and for a list of orders, each with its
own status action: `refill`, `refill_status`, and the batch forms of both. Refill is
only available on services that offer it, and the service list response tells you which
ones do through the `refill` boolean. A refill request for a service without refill
returns an error rather than creating one.

## Does the Boostero API support webhooks?

No. This is a v2 SMM panel API and it does not push status updates to your server.
There is no callback URL to register. You read order status by calling the `status`
action, which accepts up to 100 order IDs in one request, so a polling loop over a
large number of open orders costs very little. See the polling section of the
[README](README.md#there-are-no-webhooks-status-is-polled).

If you would rather not build a loop at all, a child panel covers ordering and status
for your customers without an integration.

## What is the rate limit on the Boostero API?

There is no published per-key limit and no rate limit headers are returned. Measured on
4 September 2026, 170 sequential requests at nine per second all returned HTTP 200 with
no throttling. Concurrency is what degrades: 25 simultaneous requests all succeeded,
but the slowest took 2.5 seconds. Poll sequentially at about one request per second and
batch your order IDs.

Those are measurements on a date, not a service commitment.

## Is there a sandbox or test mode?

There is no separate sandbox environment.

Read actions are safe to call as often as you like: `services`, `status` and `balance`
change nothing. To test ordering, place one real order at the smallest quantity the
service accepts, which the service list gives you as the `min` value.

## Why did my order succeed with a broken link?

Because the link is not validated. Service ID, quantity and balance are checked, in
that order; the link is not checked at all. A malformed link is accepted, the balance
is charged, an order ID is returned, and the order fails later at the provider.

Validate links in your own code before sending them. See
[the link is not validated](README.md#the-link-is-not-validated).

## Why is my error handler missing errors?

Most likely it only checks the HTTP status code. Validation errors return **HTTP 200**
with an `error` key in the body. Authentication failures return 401 and an unknown
action returns 404, so both checks are needed: status code and body.

## Can I resell Boostero services under my own brand?

Yes, in two ways. Build your own front end on this API and keep Boostero invisible to
your customers, or open a child panel, which is a ready storefront on your own domain
with your own prices and no code to write.

## What is the difference between the API and a child panel?

The API is a set of endpoints you call from software you build and maintain. A child
panel is a complete storefront hosted for you, with its own domain, its own prices and
its own customer accounts.

Choose the API when you already have a product to plug orders into, and a child panel
when the storefront is the product.

## Where do I get support?

Telegram, email, and support tickets from your dashboard. Contact details are on
<https://boostero.com>.
