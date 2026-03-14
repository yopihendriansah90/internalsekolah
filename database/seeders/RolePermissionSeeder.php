<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $roles = collect([
            'Super Admin',
            'Admin',
            'Operator Guru',
            'Operator Siswa',
            'Kepala Sekolah',
            'Tata Usaha',
        ])->map(fn (string $role): Role => Role::findOrCreate($role, 'web'));

        $superAdminRole = $roles->firstWhere('name', 'Super Admin');

        if ($superAdminRole) {
            $superAdminRole->syncPermissions(Permission::query()->pluck('name')->all());
        }
    }
}
