<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Venue permissions
            'view venues',
            'create venues',
            'edit venues',
            'delete venues',
            'approve venues',
            'feature venues',
            
            // Booking permissions
            'view bookings',
            'create bookings',
            'edit bookings',
            'delete bookings',
            'approve bookings',
            
            // Review permissions
            'view reviews',
            'create reviews',
            'edit reviews',
            'delete reviews',
            'approve reviews',
            
            // User permissions
            'view users',
            'create users',
            'edit users',
            'delete users',
            
            // Payment permissions
            'view payments',
            'process payments',
            'refund payments',
            
            // Report permissions
            'view reports',
            
            // Settings permissions
            'manage settings',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo([
            'view venues', 'edit venues', 'delete venues', 'approve venues', 'feature venues',
            'view bookings', 'edit bookings', 'delete bookings', 'approve bookings',
            'view reviews', 'edit reviews', 'delete reviews', 'approve reviews',
            'view users', 'edit users',
            'view payments', 'process payments', 'refund payments',
            'view reports',
            'manage settings',
        ]);

        $role = Role::create(['name' => 'venue-owner']);
        $role->givePermissionTo([
            'view venues', 'create venues', 'edit venues',
            'view bookings', 'approve bookings',
            'view reviews',
            'view payments',
        ]);

        $role = Role::create(['name' => 'customer']);
        $role->givePermissionTo([
            'view venues',
            'create bookings', 'view bookings',
            'create reviews', 'view reviews',
            'view payments',
        ]);

        // Create a super-admin user
        $user = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@partyplex.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('super-admin');
    }
}
