<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->updateOrCreate(
            ['email' => 'admin@mail.com'],
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'password' => Hash::make('admin'),
                'is_active' => true,
                'email_verified_at' => now(),
            ],
        );

        $superAdminRole = Role::query()->where('name', 'Super Admin')->first();

        if ($superAdminRole) {
            $user->syncRoles([$superAdminRole]);
        }
    }
}
