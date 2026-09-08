/**
 * Boostero API example, Node.js.
 * Full reference: https://boostero.com/api
 *
 * Replace API_KEY with the key from your account panel.
 * Node 18+ has fetch built in; on older versions install node-fetch.
 */

const API_URL = 'https://boostero.com/api/v2';
const API_KEY = 'YOUR_API_KEY';

async function boostero(params) {
  const body = new URLSearchParams({ ...params, key: API_KEY });

  const response = await fetch(API_URL, { method: 'POST', body });
  if (!response.ok) {
    throw new Error(`HTTP ${response.status}`);
  }

  const data = await response.json();
  if (data && data.error) {
    throw new Error(`API error: ${data.error}`);
  }

  return data;
}

(async () => {
  // List the service catalogue
  const services = await boostero({ action: 'services' });
  console.log(`Services available: ${services.length}`);

  // Read the account balance
  const balance = await boostero({ action: 'balance' });
  console.log(`Balance: ${balance.balance} ${balance.currency}`);

  // Place an order
  const order = await boostero({
    action: 'add',
    service: 1,
    link: 'https://example.com/your-profile',
    quantity: 100,
  });
  console.log(`Order created: ${order.order}`);

  // Check one order
  console.log(await boostero({ action: 'status', order: order.order }));

  // Check several orders at once
  console.log(await boostero({ action: 'status', orders: '1,2,3' }));
})();
