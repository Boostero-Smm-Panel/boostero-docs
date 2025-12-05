📈 Boostero — Social Media Growth Platform & API Documentation

Boostero is a modern SMM platform designed for creators, agencies, and digital businesses that want reliable tools to improve engagement, visibility, and account momentum across major social media platforms. With fast delivery, a clean dashboard, and a powerful API, Boostero makes it easy to automate growth workflows at scale.

👉 Official Website: https://boostero.com

🚀 Platform Overview

Boostero supports engagement and visibility tools for:

Instagram

TikTok

YouTube

Facebook

Twitter/X

Spotify

Telegram

And more

Use Boostero to:

Improve early engagement

Strengthen social proof

Boost reach on new posts

Automate repetitive SMM tasks

Support high-volume client campaigns

🔧 API Quick Start
Base URL
https://boostero.com/api/v2

Authentication

Each request must include:

key — your API key

action — the API method you want to call

Basic cURL Example
curl -X POST https://boostero.com/api/v2 \
  -d "key=YOUR_API_KEY" \
  -d "action=balance"

📘 Available API Actions
Action	Description
services	Retrieve all available services
add	Create a new order
status	Check order status
balance	Get account balance
refill	Request a refill
refill_status	Check refill status
cancel	Cancel one or more orders
🧩 PHP Integration Example
$api = new Api();
$api->api_key = 'YOUR_API_KEY';

// Get services
$services = $api->services();

// Add order
$order = $api->order([
    'service' => 1,
    'link' => 'http://example.com',
    'quantity' => 100
]);

// Check status
$status = $api->status($order->order);

📦 JSON Response Examples
Order Response
{
  "order": 123456,
  "status": "processing",
  "charge": "0.75",
  "start_count": 100,
  "remains": 50,
  "currency": "USD"
}

Error Response
{
  "error": "Incorrect service ID"
}

⚠️ Error Handling
Error	Meaning
Incorrect API key	Invalid or missing key
Incorrect service ID	Service does not exist
Not enough funds	Balance too low
Invalid link	Link format is incorrect
Quantity out of range	Less or more than allowed

Tip: Always validate service IDs, quantities, and URL formats.

🚦 Rate Limits

Recommended: 1–3 requests per second

For large workloads: use multiStatus and multiRefill

🔐 Security Guidelines

Do not expose your API key publicly.

Use environment variables (.env) in production.

Sanitize user input when generating orders.

Avoid logging complete API requests.

🛠 Common Use Cases

Boostero API is typically used for:

Agency dashboards

Automated SMM tools

Creator growth apps

Marketing platforms

Cron-based order systems

Analytics and reporting tools

📅 Roadmap

Planned documentation and API enhancements:

Webhook support

Order history endpoint

Service categories

Pagination for large responses

Official SDKs (Node.js, Python, PHP)

💬 Support

Need help integrating the API?

👉 Visit: https://boostero.com

👉 Use live chat on the website

🏁 Summary

Boostero provides a powerful, easy-to-use API for automating social media engagement and growth tasks. Use this documentation to quickly integrate orders, track statuses, request refills, and scale your workflows efficiently.
