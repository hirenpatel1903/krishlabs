<?php
namespace Database\Seeders;

use App\Models\CategoryProduct;
use Illuminate\Database\Seeder;

class CategoryProductTableSeeder extends Seeder
{
    public function run()
    {
        factory(CategoryProduct::class, 30)->create();
    }
}
