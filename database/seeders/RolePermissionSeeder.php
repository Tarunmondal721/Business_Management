<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\PosUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
 public function run(): void
{
    $guard = 'web';

    // --------------------------------
    // MODULE PERMISSIONS (Removed duplicates)
    // --------------------------------
    $modules = [
       'role'
    ];

    $defaultActions = ['view','create','edit','delete'];

    foreach ($modules as $module) {
        foreach ($defaultActions as $action) {
            Permission::firstOrCreate([
                'name' => "$module.$action",
                'guard_name' => $guard
            ]);
        }
    }

    // --------------------------------
    // CREATE ROLES
    // --------------------------------
    $roles = [
        'admin',
        'operations manager',
        'company director',
        'deputy ops manager',
    ];

    foreach ($roles as $roleName) {
        $role = Role::firstOrCreate([
            'name' => $roleName,
            'guard_name' => $guard,
        ]);

        // Give all permissions (you can customize later)
        $role->syncPermissions(Permission::all());
    }

    // --------------------------------
    // CREATE ADMINS (Use updateOrCreate)
    // --------------------------------
    $admins = [
        [
            'name' => 'Super Admin',
            // 'last_name'  => 'Admin',
            'email'      => 'admin.tarun@yopmail.com',
            'phone'      => '1234567890',
            'role'       => 'admin'
        ],
        // [
        //     'first_name' => 'Talha',
        //     'last_name'  => 'Master',
        //     'email'      => 'info@kidzcorneruk.com',
        //     'phone'      => '07931116688',
        //     'role'       => 'operations manager'
        // ],
        // [
        //     'first_name' => 'Siraj',
        //     'last_name'  => 'Master',
        //     'email'      => 'kidzuk@live.co.uk',
        //     'phone'      => '07507400035',
        //     'role'       => 'company director'
        // ],
        // [
        //     'first_name' => 'Sajid',
        //     'last_name'  => 'Patel',
        //     'email'      => 'accounts@kidzcorneruk.com',
        //     'phone'      => '07507400039',
        //     'role'       => 'company director'
        // ],
        // [
        //     'first_name' => "Ma'az",
        //     'last_name'  => 'Patel',
        //     'email'      => 'kidzcorneruk@gmail.com',
        //     'phone'      => '07495863339',
        //     'role'       => 'deputy ops manager'
        // ],
    ];

    foreach ($admins as $adminData) {

        $role = Role::where('name', $adminData['role'])
                    ->where('guard_name', $guard)
                    ->first();

        $admin = User::updateOrCreate(
            ['email' => $adminData['email']],
            [
                'name' => $adminData['name'],

                'password'   => bcrypt('password'),
                'phone'      => $adminData['phone'],
                'status'     => true,
                'role_id'    => $role->id,
                'role_name'  => $role->name,
            ]
        );

        $admin->syncRoles([$role->name]);
    }


    echo "Roles and Admins seeded successfully.\n";
}
}
