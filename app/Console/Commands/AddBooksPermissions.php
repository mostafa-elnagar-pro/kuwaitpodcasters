<?php

namespace App\Console\Commands;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class AddBooksPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:add-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add books permissions to admin role';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Adding books permissions...');

        $permissionsMap = [
            'c' => 'create',
            'r' => 'read',
            'u' => 'update',
            'd' => 'delete',
        ];

        $module = 'books';
        $permissionsValue = 'c,r,u,d';
        $permissions = [];

        foreach (explode(',', $permissionsValue) as $perm) {
            $permissionValue = $permissionsMap[$perm];

            $permission = Permission::firstOrCreate(
                [
                    'group' => $module,
                    'name' => $module . '-' . $permissionValue,
                ],
                [
                    'display_name' => ucfirst($permissionValue) . ' ' . \Str::headline($module),
                ]
            );

            $permissions[] = $permission->id;

            $this->info("Created/Found permission: {$permission->name}");
        }

        // Get admin role
        $adminRole = Role::where('name', 'admin')->first();

        if (!$adminRole) {
            $this->error('Admin role not found!');
            return 1;
        }

        // Add permissions to admin role (without removing existing ones)
        $existingPermissions = $adminRole->permissions()->pluck('permissions.id')->toArray();
        $allPermissions = array_unique(array_merge($existingPermissions, $permissions));
        $adminRole->permissions()->sync($allPermissions);

        // Clear cache
        Cache::forget("laratrust_permissions_for_role_{$adminRole->id}");

        $this->info('Books permissions added successfully to admin role!');
        return 0;
    }
}
