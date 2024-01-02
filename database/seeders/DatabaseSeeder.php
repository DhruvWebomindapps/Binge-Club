<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'name' => 'Admin',
            'phone' => '9090909090',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
        ]);
        Country::create([
            'name'=>'India',
            'status'=>true,
        ]);
        $this->call(RoleSeeder::class);
        $this->call(permissionSeeder::class);
    }
}
