<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'اضافة مستخدم',
            'تعديل مستخدم',
            'حذف مستخدم',
            'عرض مستخدم',
            
            'اضافة تعبئة وقود',
            'تعديل تعبئة وقود',
            'حذف تعبئة وقود',
            'عرض تعبئة وقود',
            
            'اضافة سائق',
            'تعديل سائق',
            'حذف سائق',
            'عرض سائق',
            
            'اضافة قسم',
            'تعديل قسم',
            'حذف قسم',
            'عرض قسم',
            
            'اضافة ماركة سيارة',
            'تعديل ماركة سيارة',
            'حذف ماركة سيارة',
            'عرض ماركة سيارة',
            
            'اضافة سيارة',
            'تعديل سيارة',
            'حذف سيارة',
            'عرض سيارة',
            
            'اضافة خزان',
            'تعديل خزان',
            'حذف خزان',
            'عرض خزان',
            
            'اضافة صلاحية',
            'تعديل صلاحية',
            'حذف صلاحية',
            'عرض صلاحية',
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission]);
        }

        $superAdminRole = Role::updateOrCreate(['name' => 'Super Admin']);
        $superAdminRole->givePermissionTo($permissions);

        $superAdmin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Super Admin', 'password' => Hash::make('password')]
        );
        $superAdmin->assignRole($superAdminRole);
    }
}
