<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Role::create([
            'id' => 0,
            'name' => 'admin',
      
        ]);

        Role::create([
            'id' => 1,
            'name' => 'staff',
          
        ]);

        Role::create([
            'id' => 2,
            'name' => 'user',
          
        ]);
    }
}
