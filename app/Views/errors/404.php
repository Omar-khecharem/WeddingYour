<?php
/**
 * 404 Error Page
 */
$appName = APP_NAME;
$appUrl = APP_URL;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | <?= $appName ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Montserrat', sans-serif; background: #fafafa; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
    </style>
</head>
<body>
    <div class="text-center px-6 max-w-lg">
        <div class="text-[120px] font-extrabold text-primary-red leading-none mb-4">404</div>
        <h1 class="text-2xl font-bold text-gray-800 mb-3">Page Not Found</h1>
        <p class="text-gray-500 text-sm mb-8">The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
        <a href="<?= $appUrl ?>" class="maroon-btn inline-block">
            <i class="fa-solid fa-house mr-2"></i> Back to Home
        </a>
    </div>
</body>
</html>
