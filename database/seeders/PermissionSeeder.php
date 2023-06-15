<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder{
    /**
     * Run the database seeds.
     */

    public function run(): void{
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-show',
            'user-create',
            'user-edit',
            'user-delete',
            'user-profile',
            'user-role',
            'user-permission',
            'user-assign-role',
            'user-revoke-role',
            'user-assign-permission',
            'user-revoke-permission',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::create(['name' => $permission]);
        }

        // create roles and assign existing permissions

        $roles = [
            'Super-Admin',
            'Admin',
            'User',
        ];

        foreach ($roles as $role) {
            \Spatie\Permission\Models\Role::create(['name' => $role]);
        }

        // assign roles to users

        // admin
        $role1 = Role::create(['name' => 'Admin']);
        $role1->givePermissionTo('user-list');
        $role1->givePermissionTo('user-show');
        $role1->givePermissionTo('user-create');
        $role1->givePermissionTo('user-edit');
        $role1->givePermissionTo('user-delete');
        $role1->givePermissionTo('user-profile');
        $role1->givePermissionTo('user-role');
        $role1->givePermissionTo('user-permission');
        $role1->givePermissionTo('user-assign-role');
        $role1->givePermissionTo('user-revoke-role');
        $role1->givePermissionTo('user-assign-permission');
        $role1->givePermissionTo('user-revoke-permission');
        $role1->givePermissionTo('role-list');
        $role1->givePermissionTo('role-create');
        $role1->givePermissionTo('role-edit');
        $role1->givePermissionTo('role-delete');
        $role1->givePermissionTo('assign roles');
        $role1->givePermissionTo('user-list');
        $role1->givePermissionTo('user-show');
        $role1->givePermissionTo('user-create');

        // user
        $role2 = Role::create(['name' => 'User']);
        $role2->givePermissionTo('user-list');
        $role2->givePermissionTo('user-show');
        $role2->givePermissionTo('user-create');
        $role2->givePermissionTo('user-edit');
        $role2->givePermissionTo('user-delete');
        $role2->givePermissionTo('user-profile');
        $role2->givePermissionTo('user-role');
        $role2->givePermissionTo('user-permission');
        $role2->givePermissionTo('user-assign-role');
        $role2->givePermissionTo('user-revoke-role');
        $role2->givePermissionTo('user-assign-permission');
        $role2->givePermissionTo('user-revoke-permission');

        // super admin
 
    
    }

}
