# Boostero: Social Media Growth Platform & API Documentation

Boostero is a social media marketing panel built for creators, agencies, and digital businesses that want reliable tools to improve engagement, visibility, and account momentum across major social platforms. With fast delivery, a clean dashboard, and a full API, Boostero makes it easy to automate growth workflows at scale.

Running since 2020, Boostero has delivered 11.9M+ orders for 209,000+ registered users across 125+ countries, with a 99.7% order completion rate and 1,600+ services across 23+ platforms.

Official website: https://boostero.com

## Platform Overview

Boostero supports engagement and visibility tools for:
- Instagram
- TikTok
- YouTube
- Facebook
- Twitter/X
- Spotify
- Telegram
- And more

Use Boostero to:
- Improve early engagement
- Strengthen social proof
- Boost reach on new posts
- Automate repetitive SMM tasks
- Support high-volume client campaigns

## API Quick Start

### Base URL
```
https://boostero.com/api/v2
```

### Authentication
Each request must include:
- `key`, your API key
- `action`, the API method you want to call

### Basic cURL Example
```bash
curl -X POST https://boostero.com/api/v2 \
  -d "key=YOUR_API_KEY" \
  -d "action=balance"
```

## Available API Actions

| Action          | Description                 |
|-----------------|-----------------------------|
| `services`      | Retrieve all available services |
| `add`           | Create a new order          |
| `status`        | Check order status          |
| `balance`       | Get account balance         |
| `refill`        | Request a refill            |
| `refill_status` | Check refill status         |
| `cancel`        | Cancel one or more orders   |

## PHP Integration Example

```php
$api = new Api();
$api->api_key = 'YOUR_API_KEY';

// Get services
$services = $api->services();

// Add order
$order = $api->order([
    'service'  => 1,
    'link'     => 'http://example.com',
    'quantity' => 100
]);

// Check status
$status = $api->status($order->order);
```

## JSON Response Examples

### Order Response
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

### Error Response
```json
{
  "error": "Incorrect service ID"
}
```

## Error Handling

| Error                 | Meaning                    |
|-----------------------|----------------------------|
| Incorrect API key     | Invalid or missing key     |
| Incorrect service ID  | Service does not exist     |
| Not enough funds      | Balance too low            |
| Invalid link          | Link format is incorrect   |
| Quantity out of range | Less or more than allowed  |

Tip: always validate service IDs, quantities, and URL formats.

## Rate Limits
- Recommended: 1 to 3 requests per second.
- For large workloads, batch status and refill checks where supported.

## Security Guidelines
- Do not expose your API key publicly.
- Use environment variables (.env) in production.
- Sanitize user input when generating orders.
- Avoid logging complete API requests.

## Common Use Cases

The Boostero API is typically used for:
- Agency dashboards
- Automated SMM tools
- Creator growth apps
- Marketing platforms
- Cron-based order systems
- Analytics and reporting tools

## Support

Need help integrating the API?
- Telegram: https://t.me/boostero_smm
- Email: support@boostero.com
- Support tickets from your Boostero dashboard

## Summary

Boostero provides a reliable, easy-to-use API for automating social media engagement and growth tasks. Use this documentation to integrate orders, track statuses, request refills, and scale your workflows efficiently.
