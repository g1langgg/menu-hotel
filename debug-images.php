<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Debug image paths...\n";

// Get menu with image
$menu = App\Models\Menu::whereNotNull('image')->first();

if ($menu) {
    echo "Menu found: " . $menu->name . "\n";
    echo "Image path in DB: " . $menu->image . "\n\n";
    
    // Check storage path
    $storagePath = storage_path('app/public/' . $menu->image);
    echo "Storage path: " . $storagePath . "\n";
    echo "Storage exists: " . (file_exists($storagePath) ? 'YES' : 'NO') . "\n\n";
    
    // Check public path
    $publicPath = public_path('storage/' . $menu->image);
    echo "Public path: " . $publicPath . "\n";
    echo "Public exists: " . (file_exists($publicPath) ? 'YES' : 'NO') . "\n\n";
    
    // Check asset URL
    $assetUrl = asset('storage/' . $menu->image);
    echo "Asset URL: " . $assetUrl . "\n\n";
    
    // List directories
    echo "Storage dir listing:\n";
    if (is_dir(storage_path('app/public'))) {
        $files = scandir(storage_path('app/public'));
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                echo "  - " . $file . "\n";
            }
        }
    }
    
    echo "\nPublic storage dir listing:\n";
    if (is_dir(public_path('storage'))) {
        $files = scandir(public_path('storage'));
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                echo "  - " . $file . "\n";
            }
        }
    }
} else {
    echo "No menu with image found\n";
}
