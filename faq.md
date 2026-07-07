# Frequently Asked Questions: Boostero

## What is an SMM panel?

A Social Media Marketing (SMM) panel is an online service that provides engagement tools across social platforms, such as followers, likes, views, comments, and more. Panels help creators, brands, and agencies boost visibility and social proof when organic reach is limited.

## How does Boostero work?

Boostero operates as a modern SMM panel. Users select a service, provide the required link or account info, and place an order. Boostero's system processes the request and delivers engagement per the order parameters. The platform automates delivery and maintains quality so your content gets a chance to be seen.

## Which services are available?

Boostero supports a wide range of services across multiple platforms: Instagram, TikTok, YouTube, Facebook, Twitter/X, Telegram, Spotify, and more. Services include followers, likes, views, story views, comments, reposts, and other engagement tools, so you can choose based on your goals.

## Is Boostero safe to use?

Yes. Boostero uses secure APIs, safe delivery methods, and quality control to ensure services are delivered professionally. We recommend using realistic order quantities and avoiding rapid mass ordering to stay within safe growth behavior.

## Do I need to provide login credentials?

No. Boostero does not require your account password. All services are delivered via external methods. You only provide public links (for example, a post URL or profile URL) or identifiers as specified in the service instructions.

## How fast is the delivery?

Delivery speed depends on the chosen service and quantity. Many orders start automatically within minutes. Larger orders may take longer depending on volume and platform load.

## What payment methods are supported?

Boostero supports cards, PayPal, cryptocurrency, and Payoneer. Check the current payment options on the website checkout page, as they may vary by region.

## Is there a refund or refill policy?

Yes. If a service drops (for example, followers or likes disappear), Boostero offers a refill on eligible services, and a refund policy applies to orders that fail to start or complete. You can request a refill within the specified refill window. Read the terms during checkout.

## Can I use Boostero for clients (agency or reseller)?

Yes. Boostero supports agency and reseller use cases. Through the API and bulk order tools, you can manage multiple accounts or clients, automating orders, statuses, and deliveries.

## Does using an SMM panel violate social media platform rules?

Using SMM services may conflict with some platforms' terms of service. While many users rely on panels for growth boosts, we recommend using services responsibly and focusing on organic-quality content alongside any boosts to reduce potential penalties.

## How do I place an order using the API?

Use the Boostero API endpoint with your API key. Example with PHP:

```php
$api = new Api();
$api->api_key = 'YOUR_API_KEY';
$order = $api->order([
    'service'  => 1,
    'link'     => 'https://yourposturl.com',
    'quantity' => 100
]);
print_r($order);
```

See the full API documentation in this repository for details on all available actions (services, status, refill, cancel, balance).

## Where can I get support or help?

For support, reach Boostero on Telegram at https://t.me/boostero_smm, by email at support@boostero.com, or through the support tickets in your dashboard.
