# Boostero: Social Media Growth Tools & API Documentation

Boostero is a social media marketing panel built for creators, agencies, and businesses that want reliable, scalable engagement tools. With fast delivery, a clean dashboard, and a full API, Boostero helps you grow visibility and engagement across major social platforms.

Running since 2020, Boostero has delivered 11.9M+ orders for 209,000+ registered users across 125+ countries, with a 99.7% order completion rate and 1,600+ services across 23+ platforms.

For full platform info, pricing, and dashboard access, [**visit our website**](https://boostero.com "Boostero Social Media Growth Platform").

---

## Table of Contents
- [Overview](#overview)
- [Features](#features)
- [API Quick Start](#api-quick-start)
- [Available API Actions](#available-api-actions)
- [PHP Integration Example](#php-integration-example)
- [JSON Response Examples](#json-response-examples)
- [Error Handling](#error-handling)
- [Rate Limits](#rate-limits)
- [Security Guidelines](#security-guidelines)
- [Use Cases](#use-cases)
- [Support](#support)
- [Visit Our Website](#visit-our-website)

---

## Overview
Boostero provides reliable engagement across Instagram, TikTok, YouTube, Facebook, Twitter/X, Spotify, Telegram, and more.
Its API lets creators and agencies automate orders, track statuses, request refills, and integrate Boostero into custom dashboards or tools.

Boostero is designed for:
- Creators seeking more visibility
- Small businesses building social proof
- Agencies managing multiple clients
- Developers automating social media workflows

---

## Features
- **Fast order processing.** Many services start within minutes.
- **Full API** for automating orders and tracking statuses.
- **Safe delivery** with refill on eligible services.
- **Wide service catalog** across all major social platforms.
- **Agency-friendly** workflows and automation support.
- **Clean dashboard** for easy use.

---

## API Quick Start

### Base URL
```
https://boostero.com/api/v2
```

### Authentication
Every request must include:
- `key`, your API key
- `action`, the type of request

### Example (cURL)
```bash
curl -X POST https://boostero.com/api/v2 \
  -d "key=YOUR_API_KEY" \
  -d "action=balance"
```

---

## Available API Actions

| Action          | Description                 |
|-----------------|-----------------------------|
| `services`      | Get all available services  |
| `add`           | Create a new order          |
| `status`        | Check order status          |
| `balance`       | Get account balance         |
| `refill`        | Request a refill            |
| `refill_status` | Check refill status         |
| `cancel`        | Cancel one or more orders   |

---

## PHP Integration Example

```php
$api = new Api();
$api->api_key = 'YOUR_API_KEY';

// Get services
$services = $api->services();

// Add an order
$order = $api->order([
    'service'  => 1,
    'link'     => 'http://example.com',
    'quantity' => 100
]);

// Check status
$status = $api->status($order->order);
```

---

## JSON Response Examples

### Successful Order
```json
{
  "order": 123456,
  "status": "processing",
  "charge": "0.75",
  "start_count": 100,
  "remains": 50,
  "currency": "USD"
}
```

### Error Example
```json
{
  "error": "Incorrect service ID"
}
```

---

## Error Handling

| Error Message         | Meaning                    |
|-----------------------|----------------------------|
| Incorrect API key     | Invalid or missing key     |
| Incorrect service ID  | Service does not exist     |
| Not enough funds      | Balance too low            |
| Invalid link          | Link format is incorrect   |
| Quantity out of range | Less or more than allowed  |

Tip: always validate service IDs, quantities, and URL formats.

---

## Rate Limits
- Recommended: 1 to 3 requests per second.
- For large workloads, batch status and refill checks where supported.

---

## Security Guidelines
- Do not expose your API key publicly.
- Use environment variables (.env) in production.
- Sanitize user input when generating orders.
- Avoid logging complete API requests.

---

## Use Cases
The Boostero API is typically used for:
- Agency dashboards
- Automated SMM tools
- Creator growth apps
- Marketing platforms
- Cron-based order systems
- Analytics and reporting tools

---

## Support
Need help integrating the API?
- Telegram: [t.me/boostero_smm](https://t.me/boostero_smm)
- Email: support@boostero.com
- Support tickets from your Boostero dashboard

---

## Visit Our Website
For full platform info, pricing, and your dashboard, visit [boostero.com](https://boostero.com).

Boostero focuses on real, lasting engagement, delivered fast and backed by real support since 2020.
