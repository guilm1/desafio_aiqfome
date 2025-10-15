<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserDatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => env('USER_EMAIL_DEFAULT')
            ],
            [
                'name' => env('USER_NAME_DEFAULT'),
                'email' => env('USER_EMAIL_DEFAULT'),
                'password' => bcrypt(env("USER_PASSWORD_DEFAULT")),
            ]
        );
    }
}
