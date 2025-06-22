<?php

// database/seeders/RolePermissionSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Clear cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'manajemen buku',
        'peminjaman buku',
        'melihat laporan',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $librarian = Role::firstOrCreate(['name' => 'librarian']);
        $librarian->givePermissionTo(['lend books', 'view reports']);

        $member = Role::firstOrCreate(['name' => 'member']);
        $member->givePermissionTo([]); // View-only access

        // Assign role to user (for example)
        $user = User::first(); // make sure a user exists
        if ($user) {
            $user->assignRole('admin');
        }
    }
}
