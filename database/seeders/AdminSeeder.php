<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Admin::create([
            'name' => 'admin',
            'email' => 'admin@todo.com',
            'password' => '12345678'
        ]);

        Admin::create([
            'name' => 'admin2',
            'email' => 'admin2@todo.com',
            'password' => '12345678'
        ]);
    }
}
