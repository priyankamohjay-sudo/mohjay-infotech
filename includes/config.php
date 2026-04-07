<?php

// Include composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Load .env variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Base URL for local
//define('BASE_URL', 'http://localhost/mohjay-infotech/');

// Base URL for server
define('BASE_URL', 'https://www.mohjayinfotech.com/');

// SMTP Configuration (Loaded from .env)
define('SMTP_HOST', $_ENV['SMTP_HOST'] ?? 'smtpout.secureserver.net');
define('SMTP_USER', $_ENV['SMTP_USER'] ?? '');
define('SMTP_PASS', $_ENV['SMTP_PASS'] ?? '');
define('SMTP_PORT', $_ENV['SMTP_PORT'] ?? 587);
define('SMTP_SECURE', $_ENV['SMTP_SECURE'] ?? 'ssl');

// Contact Email Configuration (Loaded from .env)
define('CONTACT_EMAIL', $_ENV['CONTACT_EMAIL'] ?? 'support@mohjayinfotech.com');
define('FROM_EMAIL', $_ENV['FROM_EMAIL'] ?? 'support@mohjayinfotech.com');
define('FROM_NAME', $_ENV['FROM_NAME'] ?? 'Mohjay Infotech');

// Error logging function
function log_error($message) {
    $log_file = __DIR__ . '/../logs/error.log';
    $timestamp = date('Y-m-d H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $formatted_message = "[$timestamp] [IP: $ip] $message" . PHP_EOL;
    file_put_contents($log_file, $formatted_message, FILE_APPEND);
}

// Include database connection
require_once __DIR__ . '/db.php';

?>

