<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(SettingTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(RolePermissionTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(AdminPermissionTableSeeder::class);
        $this->call(BackendMenuTableSeeder::class);
        $this->call(LanguageSeeder::class);
//        $this->call(CategoryTableSeeder::class);
//        $this->call(ProductTableSeeder::class);
//        $this->call(ShopTableSeeder::class);

    }
}
