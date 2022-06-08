<?php
namespace Database\Seeders;

use App\Models\BackendMenu;
use Illuminate\Database\Seeder;

class BackendMenuTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $parent = [
            'product' 	=> 4,
            'customer' 	=> 12,
            'administrator' 		=> 15,
            'report'    => 19,
        ];

        $menus = [
            [
                'name'      => 'dashboard',
                'link'      => 'dashboard',
                'icon'      => 'fas fa-laptop',
                'parent_id' => 0,
                'priority'  => 500,
                'status'    => 1,
            ],

            [
                'name'      => 'shops',
                'link'      => 'shop',
                'icon'      => 'fas fa-university',
                'parent_id' => 0,
                'priority'  => 510,
                'status'    => 1,
            ],

            [
                'name'      => 'categories',
                'link'      => 'category',
                'icon'      => 'fas fa-list-ul',
                'parent_id' => 0,
                'priority'  => 400,
                'status'    => 1,
            ],

            [
                'name'      => 'products',
                'link'      => '#',
                'icon'      => 'fas fa-gift',
                'parent_id' => 0,
                'priority'  => 460,
                'status'    => 1,
            ],
            [
                'name'      => 'units',
                'link'      => 'unit',
                'icon'      => 'fas fa-star',
                'parent_id' => $parent['product'],
                'priority'  => 480,
                'status'    => 1,
            ],
            [
                'name'      => 'products',
                'link'      => 'products',
                'icon'      => 'fas fa-gift',
                'parent_id' => $parent['product'],
                'priority'  => 460,
                'status'    => 1,
            ],
            [
                'name'      => 'barcode_level',
                'link'      => 'barcode',
                'icon'      => 'fa fa-barcode',
                'parent_id' => $parent['product'],
                'priority'  => 460,
                'status'    => 1,
            ],


            [
                'name'      => 'purchase',
                'link'      => 'purchase',
                'icon'      => 'fas fa-newspaper',
                'parent_id' => 0,
                'priority'  => 460,
                'status'    => 1,
            ],
            [
                'name'      => 'pos',
                'link'      => 'pos',
                'icon'      => 'fas fa-th',
                'parent_id' => 0,
                'priority'  => 460,
                'status'    => 1,
            ],
            [
                'name'      => 'sales',
                'link'      => 'sale',
                'icon'      => 'fas fa-newspaper',
                'parent_id' => 0,
                'priority'  => 440,
                'status'    => 1,
            ],
            [
                'name'      => 'stock',
                'link'      => 'stock',
                'icon'      => 'fas fa-braille',
                'parent_id' => 0,
                'priority'  => 460,
                'status'    => 1,
            ],

            [
                'name'      => 'customers',
                'link'      => '#',
                'icon'      => 'fas fa-address-book',
                'parent_id' => 0,
                'priority'  => 450,
                'status'    => 1,
            ],

            [
                'name'      => 'customers',
                'link'      => 'customers',
                'icon'      => 'fas fa-user-secret',
                'parent_id' => $parent['customer'],
                'priority'  => 490,
                'status'    => 1,
            ],

            [
                'name'      => 'deposit',
                'link'      => 'deposit',
                'icon'      => 'fas fa-dollar-sign',
                'parent_id' => $parent['customer'],
                'priority'  => 490,
                'status'    => 1,
            ],

            [
                'name'      => 'administrator',
                'link'      => '#',
                'icon'      => 'fas fa-id-card ',
                'parent_id' => 0,
                'priority'  => 450,
                'status'    => 1,
            ],
            [
                'name'      => 'administrators',
                'link'      => 'administrators',
                'icon'      => 'fas fa-users',
                'parent_id' => $parent['administrator'],
                'priority'  => 500,
                'status'    => 1,
            ],

            [
                'name'      => 'tax_rates',
                'link'      => 'tax',
                'icon'      => 'fas fa-percent',
                'parent_id' => $parent['administrator'],
                'priority'  => 490,
                'status'    => 1,
            ],


            [
                'name'      => 'role',
                'link'      => 'role',
                'icon'      => 'fas fa-star',
                'parent_id' => $parent['administrator'],
                'priority'  => 470,
                'status'    => 1,
            ],


            [
                'name'      => 'report',
                'link'      => '#',
                'icon'      => 'fas fa-archive',
                'parent_id' => 0,
                'priority'  => 390,
                'status'    => 1,
            ],
            [
                'name'      => 'sales_report',
                'link'      => 'sales-report',
                'icon'      => 'fas fa-list-alt',
                'parent_id' => $parent['report'],
                'priority'  => 380,
                'status'    => 1,
            ],
            [
                'name'      => 'purchases_report',
                'link'      => 'purchases-report',
                'icon'      => 'fas fa-list-alt',
                'parent_id' => $parent['report'],
                'priority'  => 375,
                'status'    => 1,
            ],
            [
                'name'      => 'stock_report',
                'link'      => 'stock-report',
                'icon'      => 'fas fa-list-alt',
                'parent_id' => $parent['report'],
                'priority'  => 370,
                'status'    => 1,
            ],

            [
                'name'      => 'language',
                'link'      => 'language',
                'icon'      => 'fas fa-globe',
                'parent_id' => 0,
                'priority'  => 9000,
                'status'    => 1,
            ],

            [
                'name'      => 'settings',
                'link'      => 'setting',
                'icon'      => 'fas fa-cogs',
                'parent_id' => 0,
                'priority'  => 360,
                'status'    => 1,
            ],

            [
                'name'      => 'addons',
                'link'      => 'addons',
                'icon'      => 'fa fa-crosshairs',
                'parent_id' => $parent['administrator'],
                'priority'  => 88,
                'status'    => 1,
            ]
        ];

        BackendMenu::insert($menus);
    }
}
