<?php

// Temp file just to test package

require __DIR__ . '/vendor/autoload.php';

use drilonnikci\PhpSalesforceApi\Authentication\SalesforceAuthRequest;

$credentials = [
    'grant_type' => 'password',
    'client_id' => 'YOUR_CONSUMER_KEY',
    'client_secret' => 'YOUR_CONSUMER_SECRET',
    'username' => 'YOUR_USERNAME',
    'password' => 'YOUR_PASSWORD',
];

$authentication = new SalesforceAuthRequest($credentials, false); // set true to use sandbox false for production

var_dump($authentication->getAccessToken());