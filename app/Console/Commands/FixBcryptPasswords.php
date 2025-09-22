<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FixBcryptPasswords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-bcrypt-passwords';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix passwords to use Bcrypt algorithm';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking and fixing passwords to use Bcrypt algorithm...');
        
        $users = User::all();
        $fixedCount = 0;
        $alreadyOkCount = 0;
        
        foreach ($users as $user) {
            if (empty($user->password)) {
                $this->warn("User {$user->email} has empty password, skipping...");
                continue;
            }
            
            // Check if password is already hashed with Bcrypt
            if (Hash::needsRehash($user->password)) {
                // If the password doesn't start with $2y$ (Bcrypt prefix)
                // we assume it's in plaintext or another format
                if (!str_starts_with($user->password, '$2y$')) {
                    $this->info("Rehashing password for user: {$user->email}");
                    
                    // Hash the current password with Bcrypt
                    $user->password = Hash::make($user->password);
                    $user->save();
                    
                    $fixedCount++;
                } else {
                    $this->line("User {$user->email} already uses Bcrypt");
                    $alreadyOkCount++;
                }
            } else {
                $this->line("User {$user->email} already uses Bcrypt");
                $alreadyOkCount++;
            }
        }
        
        $this->info('Password fix completed!');
        $this->info("Users fixed: {$fixedCount}");
        $this->info("Users already OK: {$alreadyOkCount}");
        
        return 0;
    }
}
