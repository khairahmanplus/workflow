<?php

use App\Models\Authorization\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            // Role
            'View any role',
            'View role',
            'Create role',
            'Update role',
            'Delete role',
            // User
            'View any user',
            'View user',
            'Create user',
            'Update user',
            'Delete user',
            // Workflow
            'View any workflow',
            'View workflow',
            'Create workflow',
            'Update workflow',
            'Delete workflow',
            // Module Workflow
            'View any module workflow',
            'View module workflow',
            'Create module workflow',
            'Update module workflow',
            'Delete module workflow',
            // Document
            'View any document',
            'View document',
            'Create document',
            'Update document',
            'Delete document',
            // Document Approval
            'Query - To Document Creator',
            'Review Document',
            'Query - To Document Reviewer',
            'Support Document Level 1',
            'Support Document Level 2',
            'Approve Document',
            'Deny Document'
        ];

        Permission::insert(
            collect($permissions)->map(function ($permission) {
                return [
                    'name'  => $permission,
                    'label' => Str::snake(str_replace('-', '', $permission))
                ];
            })->toArray()
        );
    }
}
