<?php
$pdo = new PDO('mysql:host=localhost;dbname=shola_ghar', 'root', '');

$files = [
    __DIR__ . '/002_add_outlets_homepage_tables.sql',
    __DIR__ . '/003_seed_settings_outlets.sql',
    __DIR__ . '/004_seed_menu_items.sql',
    __DIR__ . '/005_import_categories_to_menu.sql',
];

foreach ($files as $file) {
    if (!file_exists($file)) continue;
    $sql = file_get_contents($file);
    $pdo->exec($sql);
    echo "Executed: " . basename($file) . "\n";
}

echo "Migration complete!\n";
