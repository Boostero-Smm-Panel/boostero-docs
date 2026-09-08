"""
Boostero API example, Python.
Full reference: https://boostero.com/api

Replace API_KEY with the key from your account panel.
Requires: pip install requests
"""

import requests

API_URL = "https://boostero.com/api/v2"
API_KEY = "YOUR_API_KEY"


def boostero(**params):
    params["key"] = API_KEY

    response = requests.post(API_URL, data=params, timeout=30)
    response.raise_for_status()

    data = response.json()
    if isinstance(data, dict) and "error" in data:
        raise RuntimeError(f"API error: {data['error']}")

    return data


if __name__ == "__main__":
    # List the service catalogue
    services = boostero(action="services")
    print(f"Services available: {len(services)}")

    # Read the account balance
    balance = boostero(action="balance")
    print(f"Balance: {balance['balance']} {balance['currency']}")

    # Place an order
    order = boostero(
        action="add",
        service=1,
        link="https://example.com/your-profile",
        quantity=100,
    )
    print(f"Order created: {order['order']}")

    # Check one order
    print(boostero(action="status", order=order["order"]))

    # Check several orders at once
    print(boostero(action="status", orders="1,2,3"))
