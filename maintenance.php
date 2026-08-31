<?php
// Prevent direct access to this file if maintenance mode is not active
if (!defined('MAINTENANCE_MODE')) {
    header('HTTP/1.1 403 Forbidden');
    exit('Direct access forbidden.');
}

// Fallbacks for base URL and contact email
$baseUrl = defined('BASE_URL') ? BASE_URL : '/';
$contactEmail = defined('CONTACT_EMAIL') ? CONTACT_EMAIL : 'support@mohjayinfotech.com';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Under Maintenance | Mohjay Infotech</title>
    <link rel="icon" type="image/x-icon" href="<?= htmlspecialchars($baseUrl) ?>assets/imgs/logo/mohjay-favicon.png">
    <!-- Load Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }
        .maintenance-container {
            max-width: 550px;
            width: 100%;
            text-align: center;
            background: #ffffff;
            padding: 50px 40px;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }
        .logo {
            max-height: 60px;
            margin-bottom: 30px;
        }
        .illustration-container {
            margin-bottom: 30px;
            display: flex;
            justify-content: center;
        }
        .illustration-container svg {
            width: 100px;
            height: 100px;
            color: #4f46e5;
        }
        h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 16px;
            color: #0f172a;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
            color: #64748b;
            margin-bottom: 30px;
        }
        .divider {
            height: 1px;
            background-color: #e2e8f0;
            margin: 25px 0;
        }
        .contact-info {
            font-size: 14px;
            color: #94a3b8;
            line-height: 1.5;
        }
        .contact-info a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        .contact-info a:hover {
            color: #3730a3;
            text-decoration: underline;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .spin-animation {
            animation: spin 12s linear infinite;
            transform-origin: center;
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        <!-- Logo -->
        <img class="logo" src="<?= htmlspecialchars($baseUrl) ?>assets/imgs/logo/mohjaylogo-dark.png" alt="Mohjay Infotech" onerror="this.style.display='none';">
        
        <!-- Animated Gear Illustration -->
        <div class="illustration-container">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <g class="spin-animation">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.43l-1.003.828c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.43l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </g>
            </svg>
        </div>

        <h1>Under Maintenance</h1>
        <p>Our website is temporarily offline as we perform scheduled systems maintenance and upgrades. We apologize for the inconvenience and will be back online shortly.</p>
        
        <div class="divider"></div>
        
        <div class="contact-info">
            Need urgent assistance?<br>
            Reach out to us at <a href="mailto:<?= htmlspecialchars($contactEmail) ?>"><?= htmlspecialchars($contactEmail) ?></a>
        </div>
    </div>
</body>
</html>
