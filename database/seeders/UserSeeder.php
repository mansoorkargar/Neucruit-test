<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::firstOrCreate([
            'email' => 'admin@example.com',
            'name' => 'Admin', 'last_name' => 'Admin',
            'phone_number' => 111111111,
            'company' => 'Admin',
            'info_checked' => 1,
            'password' => ''
        ]);
        $admin->password = bcrypt('secret');
        $admin->save();

        $admin = User::firstOrCreate([
            'email' => 'user@example.com',
            'name' => 'User',
            'last_name' => 'User',
            'phone_number' => 111111111,
            'company' => 'User',
            'info_checked' => 1,
            'password' => ''
        ]);
        $admin->name     = 'User';
        $admin->password = bcrypt('secret');
        $admin->save();
    }
}
