<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Enums\ShopStatus;
use App\Enums\Status;
use App\Models\Area;
use App\Models\Location;
use App\Models\Shop;
use App\User;
use Faker\Generator as Faker;
use Spatie\Permission\Models\Role;

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

$factory->define(Shop::class, function (Faker $faker) {

    $role = Role::find(3);

    return [
        'user_id'         => User::role($role->name)->pluck('id')->random(),
        'name'            => $faker->company,
        'description'     => $faker->text(100),
        'delivery_charge' => random_int(10, 100),
        'lat'             => $faker->latitude,
        'long'            => $faker->longitude,
        'opening_time'    => $faker->time("H:i:s"),
        'closing_time'    => $faker->time("H:i:s"),
        'address'         => $faker->address,
        'status'          => ShopStatus::ACTIVE,
        'current_status'  => ShopStatus::ACTIVE,
        'applied'         => false,
        'creator_type'    => 'App\User',
        'creator_id'      => User::get()->pluck('id')->random(),
        'editor_type'     => 'App\User',
        'editor_id'       => User::get()->pluck('id')->random(),
    ];
});
