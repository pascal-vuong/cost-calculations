<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'user@test.nl'],
            [
                'name' => 'User',
                'password' => Hash::make('user123'),
            ]
        );

        $user->assignRole('user');

        User::factory(10)->create()->each(function ($user) {
            $user->assignRole('user');
        });
    }
}
