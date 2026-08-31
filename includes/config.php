<?php

// Toggle Maintenance Mode (true = enabled, false = disabled)
define('MAINTENANCE_MODE', true);

// Include composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Load .env variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Dynamically determine protocol
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || ($_SERVER['SERVER_PORT'] ?? 80) == 443) ? "https://" : "http://";
// Dynamically determine host
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
// Dynamically determine base path
$docRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'] ?? '');
$dirPath = str_replace('\\', '/', dirname(__DIR__));
$basePath = str_replace($docRoot, '', $dirPath);
$basePath = '/' . ltrim($basePath, '/');
if (substr($basePath, -1) !== '/') {
    $basePath .= '/';
}
define('BASE_URL', $protocol . $host . $basePath);

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

// Maintenance Mode Check
if (defined('MAINTENANCE_MODE') && MAINTENANCE_MODE) {
    // Exclude admin panel files from being blocked (allows admin access during maintenance)
    $current_script = $_SERVER['SCRIPT_NAME'] ?? '';
    $is_admin = (strpos($current_script, '/admin/') !== false);
    
    if (!$is_admin) {
        header('HTTP/1.1 503 Service Temporarily Unavailable');
        header('Status: 503 Service Temporarily Unavailable');
        header('Retry-After: 3600');

        // Check if it is an AJAX or JSON request
        $is_json = (
            (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) || 
            (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) ||
            (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strcasecmp($_SERVER['HTTP_X_REQUESTED_WITH'], 'xmlhttprequest') === 0)
        );

        if ($is_json) {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'maintenance',
                'message' => 'The website is currently undergoing scheduled maintenance. Please try again later.'
            ]);
            exit;
        }

        // Display maintenance page
        $maintenance_file = dirname(__DIR__) . '/maintenance.php';
        if (file_exists($maintenance_file)) {
            require_once $maintenance_file;
        } else {
            echo '<h1>Under Maintenance</h1><p>Our website is temporarily offline for scheduled maintenance. Please check back later.</p>';
        }
        exit;
    }
}

// Include database connection
require_once __DIR__ . '/db.php';

?>

