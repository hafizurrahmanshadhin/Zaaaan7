<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::table('users')->insert([
            'first_name' => 'Admin',
            'last_name'  => 'User',
            'handle'     => 'admin',
            'email'      => 'admin@admin.com',
            'password'   => Hash::make('12345678'), // Replace 'password' with a secure password
            'role'       => 'admin',
            'status'     => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
