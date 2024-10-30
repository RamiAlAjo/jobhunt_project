<?php
/**
 * PayPal Setting & API Credentials
 * Created by Raza Mehdi <srmk@outlook.com>.
 */

// Return an array of PayPal configuration settings
return [
    // Specify the mode for PayPal: 'sandbox' for testing or 'live' for production
    'mode'    => env('PAYPAL_MODE', 'sandbox'),

    // Sandbox configuration for testing environment
    'sandbox' => [
        'client_id'         => env('PAYPAL_SANDBOX_CLIENT_ID', ''),
        'client_secret'     => env('PAYPAL_SANDBOX_CLIENT_SECRET', ''),
        'app_id'            => 'APP-80W284485P519543T', // Static app ID for sandbox; used by PayPal for testing
    ],

    // Live configuration for production environment
    'live' => [
        'client_id'         => env('PAYPAL_LIVE_CLIENT_ID', ''),
        'client_secret'     => env('PAYPAL_LIVE_CLIENT_SECRET', ''),
        'app_id'            => env('PAYPAL_LIVE_APP_ID', ''), // App ID obtained from PayPal for live transactions
    ],

    // Payment action type: 'Sale' for immediate transaction, 'Authorization' to hold funds, or 'Order' for payment processing later
    'payment_action' => env('PAYPAL_PAYMENT_ACTION', 'Sale'),

    // Currency for transactions, e.g., USD, EUR
    'currency'       => env('PAYPAL_CURRENCY', 'USD'),

    // URL for PayPal to notify about the transaction status
    'notify_url'     => env('PAYPAL_NOTIFY_URL', ''),

    // Locale setting to enforce a specific language for the PayPal gateway
    'locale'         => env('PAYPAL_LOCALE', 'en_US'),

    // SSL validation flag to enforce secure API communication with PayPal
    'validate_ssl'   => env('PAYPAL_VALIDATE_SSL', true),
];