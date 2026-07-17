<?php
/**
 * 500 Server Error Page
 */
$appName = APP_NAME;
$appUrl = APP_URL;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Server Error | <?= $appName ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Montserrat', sans-serif; background: #fafafa; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
    </style>
</head>
<body>
    <div class="text-center px-6 max-w-lg">
        <div class="text-[120px] font-extrabold text-gray-300 leading-none mb-4">500</div>
        <h1 class="text-2xl font-bold text-gray-800 mb-3">Server Error</h1>
        <p class="text-gray-500 text-sm mb-8">Something went wrong on our end. We are working to fix the issue. Please try again later.</p>
        <a href="<?= $appUrl ?>" class="maroon-btn inline-block">
            <i class="fa-solid fa-house mr-2"></i> Back to Home
        </a>
    </div>
</body>
</html>
