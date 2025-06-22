<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat role jika belum ada
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $memberRole = Role::firstOrCreate(['name' => 'member']);
        $librarianRole = Role::firstOrCreate(['name' => 'librarian']);

        // Buat user admin
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'), // Password default: 'password'
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'), // Password default: 'password'
        ]);

        // Berikan role admin
        $admin->assignRole($adminRole);

        // (Opsional) Buat user member
        $member = User::factory()->create([
            'name' => 'Member User',
            'email' => 'member@example.com',
            'password' => bcrypt('password'),
        ]);
        $member->assignRole($memberRole);

        // (Opsional) Buat user librarian
        $librarian = User::factory()->create([
            'name' => 'Librarian User',
            'email' => 'librarian@example.com',
            'password' => bcrypt('password'),
        ]);
        $librarian->assignRole($librarianRole);
    }
}
