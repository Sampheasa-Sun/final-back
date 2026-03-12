<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'firstName' => 'Bath',
            'lastName' => 'Noob',
            'email' => 'alecwuwualec@gmil.com',
            'status' => 'active',
            'password_hash' => bcrypt('ilove3030'),
            'contributions' => 0,
            'knowledge_points' => 0,
            'helpful_votes' => 0,
            'profile_picture_url' => null,
        ]);
    }
}
