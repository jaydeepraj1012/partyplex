<?php

namespace Database\Seeders;

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
        // Create roles and permissions
        $this->call(RolesAndPermissionsSeeder::class);
        
        // Create venue types
        $this->call(VenueTypeSeeder::class);
        
        // Create amenities
        $this->call(AmenitySeeder::class);
        
        // Create regular users
        User::factory(10)->create()->each(function ($user) {
            $user->assignRole('customer');
        });
        
        // Create venue owners
        User::factory(5)->create()->each(function ($user) {
            $user->assignRole('venue-owner');
        });
    }
}
