// config.php
<?php
return [
    'database' => [
        'dsn' => 'sqlite:users.db'
    ],
    'smtp' => [
        'host' => 'server',
        'username' => 'noreply@mydomain.com',
        'password' => 'pass',
        'port' => 587,
        'secure' => 'tls',
        'from' => [
            'email' => 'noreply@mydomain.com',
            'name' => 'WiFi Portal'
        ],
        'subject' => 'Your WiFi access code',
        'debug' => 2
    ],
    'code' => [
        'length' => 8,
        'validity' => 86400 // 24 hours in seconds
    ],
    'verification' => [
        'error_message' => "Invalid code!",
        'success_redirect' => "success_page.php"
    ],
    'api' => [
        'duration' => 30, // Set the guest duration in minutes
        'site_id' => 'default', // Replace with your Site ID
        'controlleruser' => 'username', // Replace with your controller username
        'controllerpassword' => 'password',     
        'controllerurl' => 'https://192.168.1.1', // Replace with your controller URL
        'controllerversion' => '5.10.21', // Replace with your controller version
        'debug' => false // Set to true if you want to log the UniFi API requests
    ]
];
