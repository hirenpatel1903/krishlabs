<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Enums\CategoryStatus;
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

$factory->define(\App\Models\Category::class, function ( Faker $faker ) {

    return [
        'name'         => $faker->name,
        'slug'         => $faker->slug,
        'description'  => $faker->text(100),
        'depth'        => 1,
        'left'         => 2,
        'right'        => 3,
        'parent_id'    => null,
        'status'       => CategoryStatus::ACTIVE,
        'creator_type' => 'App\User',
        'creator_id'   => \App\Models\User::get()->pluck('id')->random(),
        'editor_type'  => 'App\User',
        'editor_id'    => \App\Models\User::get()->pluck('id')->random(),
    ];
});
