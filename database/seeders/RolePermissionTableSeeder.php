<?php
namespace Database\Seeders;

use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::find(UserRole::ADMIN);
        if (!blank($role)) {
            $role->givePermissionTo(Permission::all());
        }

        $role = Role::find(UserRole::SHOPOWNER);
        if (!blank($role)) {
            $shopOwnerPermission[]['name'] = 'dashboard';
            $shopOwnerPermission[]['name'] = 'shop';
            $shopOwnerPermission[]['name'] = 'shop_create';
            $shopOwnerPermission[]['name'] = 'shop_edit';
            $shopOwnerPermission[]['name'] = 'shop_delete';
            $shopOwnerPermission[]['name'] = 'shop_show';
            $shopOwnerPermission[]['name'] = 'category';
            $shopOwnerPermission[]['name'] = 'category_create';
            $shopOwnerPermission[]['name'] = 'category_edit';
            $shopOwnerPermission[]['name'] = 'category_delete';
            $shopOwnerPermission[]['name'] = 'category_show';
            $shopOwnerPermission[]['name'] = 'barcode';
            $shopOwnerPermission[]['name'] = 'unit';
            $shopOwnerPermission[]['name'] = 'unit_create';
            $shopOwnerPermission[]['name'] = 'unit_edit';
            $shopOwnerPermission[]['name'] = 'unit_delete';
            $shopOwnerPermission[]['name'] = 'unit_show';

            $shopOwnerPermission[]['name'] = 'tax';
            $shopOwnerPermission[]['name'] = 'tax_create';
            $shopOwnerPermission[]['name'] = 'tax_edit';
            $shopOwnerPermission[]['name'] = 'tax_delete';
            $shopOwnerPermission[]['name'] = 'tax_show';

            $shopOwnerPermission[]['name'] = 'products';
            $shopOwnerPermission[]['name'] = 'products_create';
            $shopOwnerPermission[]['name'] = 'products_edit';
            $shopOwnerPermission[]['name'] = 'products_delete';
            $shopOwnerPermission[]['name'] = 'products_show';
            $shopOwnerPermission[]['name'] = 'pos';
            $shopOwnerPermission[]['name'] = 'sale';
            $shopOwnerPermission[]['name'] = 'sale_create';
            $shopOwnerPermission[]['name'] = 'sale_edit';
            $shopOwnerPermission[]['name'] = 'sale_delete';
            $shopOwnerPermission[]['name'] = 'sale_show';
            $shopOwnerPermission[]['name'] = 'stock';
            $shopOwnerPermission[]['name'] = 'purchase';
            $shopOwnerPermission[]['name'] = 'purchase_create';
            $shopOwnerPermission[]['name'] = 'purchase_edit';
            $shopOwnerPermission[]['name'] = 'purchase_delete';
            $shopOwnerPermission[]['name'] = 'purchase_show';
            $shopOwnerPermission[]['name'] = 'purchases-report';
            $shopOwnerPermission[]['name'] = 'sales-report';
            $shopOwnerPermission[]['name'] = 'stock-report';
            $permissions                   = Permission::whereIn('name', $shopOwnerPermission)->get();
            $role->givePermissionTo($permissions);
        }

        $role = Role::find(UserRole::RECEPTIONIST);
        if (!blank($role)) {
            $ReceptionistPermission[]['name'] = 'dashboard';
            $ReceptionistPermission[]['name'] = 'customers';
            $ReceptionistPermission[]['name'] = 'customers_create';
            $ReceptionistPermission[]['name'] = 'customers_edit';
            $ReceptionistPermission[]['name'] = 'customers_show';
            $ReceptionistPermission[]['name'] = 'customers_delete';
            $ReceptionistPermission[]['name'] = 'deposit';
            $ReceptionistPermission[]['name'] = 'deposit_create';
            $ReceptionistPermission[]['name'] = 'deposit_edit';
            $ReceptionistPermission[]['name'] = 'deposit_show';
            $ReceptionistPermission[]['name'] = 'deposit_delete';
            $permissions                     = Permission::whereIn('name', $ReceptionistPermission)->get();
            $role->givePermissionTo($permissions);
        }
    }
}
