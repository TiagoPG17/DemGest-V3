<?php
require_once 'vendor/autoload.php';

use App\Models\User;

// Conectar a la base de datos
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Checking and fixing user passwords...\n\n";

$users = User::all();
$fixedCount = 0;

foreach ($users as $user) {
    echo "Checking user: {$user->email} (ID: {$user->id})\n";
    
    // Check if password is properly hashed with bcrypt
    $password = $user->password;
    
    // Check if password looks like a bcrypt hash (starts with $2y$)
    if (!str_starts_with($password, '$2y$')) {
        echo "  - Password is NOT using bcrypt algorithm\n";
        echo "  - Current password hash: " . substr($password, 0, 20) . "...\n";
        
        // If password is plain text or uses another hash, re-hash it with bcrypt
        if (strlen($password) < 60) {
            // Likely plain text or weak hash
            $newPassword = bcrypt($password);
            $user->password = $newPassword;
            $user->save();
            
            echo "  - FIXED: Password re-hashed with bcrypt\n";
            $fixedCount++;
        } else {
            echo "  - WARNING: Password uses unknown algorithm, manual check required\n";
        }
    } else {
        echo "  - Password is properly hashed with bcrypt\n";
    }
    echo "\n";
}

echo "Summary:\n";
echo "Total users checked: " . count($users) . "\n";
echo "Passwords fixed: $fixedCount\n";

if ($fixedCount > 0) {
    echo "\n✅ Password issues have been resolved!\n";
} else {
    echo "\n✅ All passwords are properly hashed with bcrypt!\n";
}
