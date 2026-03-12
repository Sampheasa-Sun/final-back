<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
//php artisan make:admin
//to create admin
class CreateAdmin extends Command
{
    protected $signature = 'make:admin';
    protected $description = 'Create a new admin account';

    public function handle()
    {
        $firstName = $this->ask('First Name');
        $lastName = $this->ask('Last Name');
        $email = $this->ask('Email');
        $password = $this->secret('Password');
        $photo = $this->ask('Photo filename (optional)', 'default.webp');

        if (Admin::where('email', $email)->exists()) {
            $this->error("An admin with email $email already exists.");
            return;
        }

        $admin = Admin::create([
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'password_hash' => Hash::make($password),
            'photo' => $photo,
        ]);

        $this->info("Admin created successfully: $admin->email");
    }
}
