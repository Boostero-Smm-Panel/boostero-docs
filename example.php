<?php
/**
 * Boostero API example, PHP.
 * Full reference: https://boostero.com/api
 *
 * Replace API_KEY with the key from your account panel.
 */

const API_URL = 'https://boostero.com/api/v2';
const API_KEY = 'YOUR_API_KEY';

function boostero(array $params) {
    $params['key'] = API_KEY;

    $ch = curl_init(API_URL);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => http_build_query($params),
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_SSL_VERIFYPEER => true,
    ]);

    $response = curl_exec($ch);
    if ($response === false) {
        throw new RuntimeException('Request failed: ' . curl_error($ch));
    }
    curl_close($ch);

    $data = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new RuntimeException('Invalid JSON in response');
    }
    if (isset($data['error'])) {
        throw new RuntimeException('API error: ' . $data['error']);
    }

    return $data;
}

// List the service catalogue
$services = boostero(['action' => 'services']);
echo 'Services available: ' . count($services) . PHP_EOL;

// Read the account balance
$balance = boostero(['action' => 'balance']);
echo 'Balance: ' . $balance['balance'] . ' ' . $balance['currency'] . PHP_EOL;

// Place an order
$order = boostero([
    'action'   => 'add',
    'service'  => 1,
    'link'     => 'https://example.com/your-profile',
    'quantity' => 100,
]);
echo 'Order created: ' . $order['order'] . PHP_EOL;

// Check one order
$status = boostero(['action' => 'status', 'order' => $order['order']]);
print_r($status);

// Check several orders at once
$multi = boostero([
    'action' => 'status',
    'orders' => implode(',', [$order['order'], 12345, 12346]),
]);
print_r($multi);
