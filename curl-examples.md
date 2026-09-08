# curl Examples

Quick reference for testing the Boostero API from a terminal.
Full reference: https://boostero.com/api

Replace `YOUR_API_KEY` with the key from your account panel.

## List the service catalogue

```bash
curl -X POST https://boostero.com/api/v2 \
  -d "key=YOUR_API_KEY" \
  -d "action=services"
```

## Read the account balance

```bash
curl -X POST https://boostero.com/api/v2 \
  -d "key=YOUR_API_KEY" \
  -d "action=balance"
```

## Place an order

```bash
curl -X POST https://boostero.com/api/v2 \
  -d "key=YOUR_API_KEY" \
  -d "action=add" \
  -d "service=1" \
  -d "link=https://example.com/your-profile" \
  -d "quantity=100"
```

## Check a single order

```bash
curl -X POST https://boostero.com/api/v2 \
  -d "key=YOUR_API_KEY" \
  -d "action=status" \
  -d "order=12345"
```

## Check several orders at once

```bash
curl -X POST https://boostero.com/api/v2 \
  -d "key=YOUR_API_KEY" \
  -d "action=status" \
  -d "orders=12345,12346,12347"
```

## Request a refill

Only for services where refill is supported. The refill terms are shown
on each service in the catalogue.

```bash
curl -X POST https://boostero.com/api/v2 \
  -d "key=YOUR_API_KEY" \
  -d "action=refill" \
  -d "order=12345"
```

## Notes

- All requests are POST with form-encoded parameters.
- Every request carries the `key` parameter.
- Errors come back as JSON with an `error` field, so check for it
  before reading the rest of the response.
