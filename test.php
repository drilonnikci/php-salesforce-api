<?php

// Temp file just to test package

require __DIR__ . '/vendor/autoload.php';

use drilonnikci\PhpSalesforceApi\Authentication\SalesforceAuthRequest;

$credentials = [
    'grant_type' => 'password',
    'client_id' => '3MVG9ux34Ig8G5eoM6hLdtcIAg2WyWEmlMao7B9h8iZqTnAwfPhc5bWkKtaT9T6qYXl3LJ3AuTE0Dk0qbFqvf',
    'client_secret' => 'B017B6D35DF92B37E29A4DA96D3BC460EAF3A745399EBD37CA9E2CF1116B854C',
    'username' => 'drilon@cydeo.com',
    'password' => '@SF.cydeo2023@new',
];

$authentication = new SalesforceAuthRequest($credentials, false); // set true to use sandbox false for production

var_dump($authentication->getAccessToken());