<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = \App\Models\Admin::create([
            'name' => 'Admin',
            'email' => 'admin@podcaster.com',
            'password' => bcrypt('password')
        ]);

        $admin->addRole(
            \App\Models\Role::first()
        );
    }
}
