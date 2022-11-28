<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRolePermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $default_user_value = [
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];

        // create user
        $it = User::create(array_merge([
            'niy' => '01234567',
            'id_karyawan' => '1'
        ], $default_user_value));

        $staff = User::create(array_merge([
            'niy' => '00021324',
            'id_karyawan' => '2'
        ], $default_user_value));

        $guru_anim = User::create(array_merge([
            'niy' => '89282132',
            'id_karyawan' => '3'
        ], $default_user_value));

        $guru_rpl = User::create(array_merge([
            'niy' => '38493812',
            'id_karyawan' => '4'
        ], $default_user_value));

        $guru_dkv = User::create(array_merge([
            'niy' => '03947382',
            'id_karyawan' => '5'
        ], $default_user_value));

        // create role
        $role_it = Role::create(['name' => 'it']);
        $role_staff = Role::create(['name' => 'staff']);
        $role_guru = Role::create(['name' => 'guru']);

        // create permission
        $permission = Permission::create(['name' => 'read absensi']);
        $permission = Permission::create(['name' => 'create absensi']);
        $permission = Permission::create(['name' => 'update absensi']);
        $permission = Permission::create(['name' => 'delete absensi']);

        // giving permission
        $role_it->givePermissionTo('read absensi');
        $role_it->givePermissionTo('create absensi');
        $role_it->givePermissionTo('update absensi');
        $role_it->givePermissionTo('delete absensi');

        $role_staff->givePermissionTo('read absensi');
        $role_staff->givePermissionTo('create absensi');
        $role_staff->givePermissionTo('update absensi');
        $role_staff->givePermissionTo('delete absensi');

        $role_guru->givePermissionTo('read absensi');
        $role_guru->givePermissionTo('create absensi');


        // assigning role to user
        $it->assignRole('it');
        $staff->assignRole('staff');
        $guru_anim->assignRole('guru');
        $guru_rpl->assignRole('guru');
        $guru_dkv->assignRole('guru');

    }
}
