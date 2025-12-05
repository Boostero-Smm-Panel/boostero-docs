# Boostero – Social Media Growth Tools & API Documentation

Boostero is a modern SMM platform designed for creators, agencies, and businesses that want reliable, scalable engagement tools. With fast delivery, a clean dashboard, and a powerful API, Boostero helps you grow visibility, engagement, and momentum across major social platforms.

👉 For full platform info, pricing, and dashboard access, [**visit our website**](https://boostero.com "Boostero – Social Media Growth Platform")

---

## 📚 Table of Contents
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
- [Roadmap](#roadmap)
- [Support](#support)
- [Visit Our Website](#visit-our-website)

---

## Overview
Boostero provides reliable engagement boosts across Instagram, TikTok, YouTube, Facebook, Twitter/X, Spotify, Telegram, and more.  
Its API allows creators and agencies to automate orders, track statuses, request refills, and integrate Boostero into custom dashboards or tools.

Boostero is designed for:
- Creators seeking more visibility  
- Small businesses building social proof  
- Agencies managing multiple clients  
- Developers automating social media workflows  

[⬆ Back to top](#-table-of-contents)

---

## Features
- ⚡ **Fast Order Processing** – Many services start within minutes  
- 🔧 **Powerful API** for automating orders and tracking statuses  
- 🛡 **Safe delivery** systems with refill options  
- 📊 **Wide service catalog** across all major social platforms  
- 👨‍💻 **Agency-friendly** workflows and automation support  
- 📱 **Clean Dashboard UI** for easy use  

[⬆ Back to top](#-table-of-contents)

---

## API Quick Start

### Base URL
```
https://boostero.com/api/v2
```

### Authentication
Every request must include:
- `key` — your API key  
- `action` — the type of request  

### Example (cURL)
```bash
curl -X POST https://boostero.com/api/v2 \
  -d "key=YOUR_API_KEY" \
  -d "action=balance"
```

[⬆ Back to top](#-table-of-contents)

---

## Available API Actions

| Action            | Description                                      |
|------------------|--------------------------------------------------|
| `services`        | Get all available services                      |
| `add`             | Create a new order                               |
| `status`          | Check order status                               |
| `balance`         | Get account balance                              |
| `refill`          | Request a refill                                 |
| `refill_status`   | Check refill status                              |
| `cancel`          | Cancel one or more orders                        |

[⬆ Back to top](#-table-of-contents)

---

## PHP Integration Example

```php
$api = new Api();
$api->api_key = 'YOUR_API_KEY';

// Get services
$services = $api->services();

// Add an order
$order = $api->order([
    'service' => 1,
    'link' => 'http://example.com',
    'quantity' => 100
]);

// Check status
$status = $api->status($order->order);
```

[⬆ Back to top](#-table-of-contents)

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

[⬆ Back to top](#-table-of-contents)

---

## Error Handling

| Error Message            | Meaning                                      |
|--------------------------|----------------------------------------------|
| Incorrect API key        | Invalid or missing key                       |
| Incorrect service ID     | Service does not exist                       |
| Not enough funds         | Account balance too low                      |
| Invalid link             | Link format is incorrect                     |
| Quantity out of range    | Below minimum or above maximum               |

[⬆ Back to top](#-table-of-contents)

---

## Rate Limits
- Recommended: **1–3 requests per second**  
- For high-volume apps: use batching (`multiStatus`, `multiRefill`)  

[⬆ Back to top](#-table-of-contents)

---

## Security Guidelines
- Never expose API keys publicly  
- Use environment variables (`.env`)  
- Validate all user input  
- Avoid logging full API requests in production  

[⬆ Back to top](#-table-of-contents)

---

## Use Cases
Boostero API is commonly used by:

- 🎯 **Agencies** automating client orders  
- 🤖 **Automation tools** needing reliable engagement  
- 📈 **Creators** boosting important posts  
- 🧩 **SaaS platforms** integrating visibility features  
- ⏱ **Cron jobs** for recurring orders  

[⬆ Back to top](#-table-of-contents)

---

## Roadmap
Planned enhancements:

- Webhooks  
- Order history endpoint  
- Service categories endpoint  
- Pagination for bulk responses  
- Official SDKs (Node.js, Python, PHP)  

[⬆ Back to top](#-table-of-contents)

---

## Support
If you need help integrating the API or have issues:

👉 Visit the support page on our website  
👉 Use live chat on the Boostero dashboard  

[⬆ Back to top](#-table-of-contents)

---

## Visit Our Website

Learn more, explore services, or access your dashboard here:

👉 [**visit our website**](https://boostero.com "Boostero – Social Media Growth Platform")

[⬆ Back to top](#-table-of-contents)
