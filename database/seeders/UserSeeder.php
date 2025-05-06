<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'name' => 'Ayat Gamal',
            'email' => 'ayatgamal@eminent-studio.com',
            'password' => bcrypt('7bWikbt3@Le')
        ]);

        $user->assignRole('admin');
    }
}
