<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions for invoices
        $invoicePermissions = [
            'view invoices',
            'create invoices',
            'edit invoices',
            'delete invoices',
        ];

        // Create permissions for quotations
        $quotationPermissions = [
            'view quotations',
            'create quotations',
            'edit quotations',
            'delete quotations',
        ];

        // Create permissions for clients
        $clientPermissions = [
            'view clients',
            'create clients',
            'edit clients',
            'delete clients',
        ];

        // Create permissions for products
        $productPermissions = [
            'view products',
            'create products',
            'edit products',
            'delete products',
        ];

        // Create permissions for currencies
        $currencyPermissions = [
            'view currencies',
            'create currencies',
            'edit currencies',
            'delete currencies',
        ];

        // Create permissions for users
        $userPermissions = [
            'view users',
            'create users',
            'edit users',
            'delete users',
            'manage roles',
        ];

        // Combine all permissions
        $allPermissions = array_merge(
            $invoicePermissions,
            $quotationPermissions,
            $clientPermissions,
            $productPermissions,
            $currencyPermissions,
            $userPermissions
        );

        // Create each permission
        foreach ($allPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        // Super Admin role - has all permissions
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $superAdminRole->givePermissionTo(Permission::all());

        // Admin role - has most permissions except managing users and roles
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(array_diff($allPermissions, ['manage roles', 'delete users']));

        // Manager role - can view everything, create and edit most things, but not delete
        $managerRole = Role::create(['name' => 'manager']);
        $managerPermissions = array_filter($allPermissions, function($permission) {
            return !str_starts_with($permission, 'delete') && $permission !== 'manage roles';
        });
        $managerRole->givePermissionTo($managerPermissions);

        // Accountant role - focused on invoices and quotations
        $accountantRole = Role::create(['name' => 'accountant']);
        $accountantRole->givePermissionTo(array_merge(
            $invoicePermissions,
            $quotationPermissions,
            ['view clients', 'view products', 'view currencies']
        ));

        // Sales role - focused on clients and quotations
        $salesRole = Role::create(['name' => 'sales']);
        $salesRole->givePermissionTo(array_merge(
            $clientPermissions,
            $quotationPermissions,
            ['view products', 'view currencies']
        ));

        // Assign super-admin role to user ID 1 (if exists)
        $adminUser = User::find(1);
        if ($adminUser) {
            $adminUser->assignRole('super-admin');
        }
    }
}
