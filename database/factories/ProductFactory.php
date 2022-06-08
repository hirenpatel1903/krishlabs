<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Enums\ProductRequested;
use App\Enums\ProductStatus;
use App\Models\Product;
use App\User;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Product::class, function ( Faker $faker ) {

    return [
        'name'              => $faker->company,
        'slug'              => $faker->slug,
        'description'       => $faker->text(100),
        'unit_price'        => random_int(10, 100),
        'status'            => ProductStatus::ACTIVE,
        'requested'         => ProductRequested::NON_REQUESTED,
        'creator_type'      => 'App\User',
        'creator_id'        => User::get()->pluck('id')->random(),
        'editor_type'       => 'App\User',
        'editor_id'         => User::get()->pluck('id')->random(),
    ];
});
