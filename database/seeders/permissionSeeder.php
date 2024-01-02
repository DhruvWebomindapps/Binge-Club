<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class permissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::insert([
            [
                'name' => 'dashboard',
                'guard_name' => 'web',
            ],
            [
                'name' => 'statelist',
                'guard_name' => 'web',
            ],
            [
                'name' => 'addstate',
                'guard_name' => 'web',
            ],
            [
                'name' => 'editstate',
                'guard_name' => 'web',
            ],
            [
                'name' => 'citylist',
                'guard_name' => 'web',
            ],
            [
                'name' => 'addcity',
                'guard_name' => 'web',
            ],
            [
                'name' => 'editcity',
                'guard_name' => 'web',
            ],
            [
                'name' => 'locationlist',
                'guard_name' => 'web',
            ],
            [
                'name' => 'addlocation',
                'guard_name' => 'web',
            ],
            [
                'name' => 'updatelocation',
                'guard_name' => 'web',
            ],
            [
                'name' => 'screenlist',
                'guard_name' => 'web',
            ],
            [
                'name' => 'addscreen',
                'guard_name' => 'web',
            ],
            [
                'name' => 'updatescreen',
                'guard_name' => 'web',
            ],
            [
                'name' => 'itemlist',
                'guard_name' => 'web',
            ],
            [
                'name' => 'additem',
                'guard_name' => 'web',
            ],
            [
                'name' => 'updateitem',
                'guard_name' => 'web',
            ],
            [
                'name' => 'deleteitem',
                'guard_name' => 'web',
            ],
            [
                'name' => 'bookinglist',
                'guard_name' => 'web',
            ],
            [
                'name' => 'addbooking',
                'guard_name' => 'web',
            ],
            [
                'name' => 'updatebooking',
                'guard_name' => 'web',
            ],
            [
                'name' => 'deletebooking',
                'guard_name' => 'web',
            ],
            [
                'name' => 'customerlist',
                'guard_name' => 'web',
            ],
            [
                'name' => 'bloglist',
                'guard_name' => 'web',
            ],
            [
                'name' => 'addblog',
                'guard_name' => 'web',
            ],
            [
                'name' => 'updateblog',
                'guard_name' => 'web',
            ],
            [
                'name' => 'deleteblog',
                'guard_name' => 'web',
            ],
        ]);
        $role = Role::findByName('super-admin');
        // $role->givePermissionTo('*');
    }
}
