<?php

namespace Database\Seeders;

use App\Enum\PermissionAction;
use App\Enum\PermissionResource;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $permissions = [];
        foreach (PermissionResource::cases() as $resource) {
            foreach (PermissionAction::cases() as $action) {
                $permissions[] = $action->value.'_'.$resource->value;
            }
        }

        $role = Role::create([
            'name' => 'SuperAdmin',
        ]);
        foreach ($permissions as $permission) {
            $p = Permission::create([
                'name' => $permission,
            ]);
            $role->givePermissionTo($p);
        }

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'image' => 'default.jpg',
            'iot_id' => Str::random(8),
            'iot_token' => Str::random(16),
        ]);
        $user->assignRole($role);
    }
}
