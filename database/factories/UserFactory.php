<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Admin;
use App\Roles;
use Illuminate\Support\Str;
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

$factory->define(Admin::class, function (Faker $faker) {
    return [
        'admin_name' => $faker->name,
        'admin_email' => $faker->unique()->safeEmail,
        'admin_phone' => '0832905658',
        'admin_password' => '1e588b997aa4c0e948ef563f98ef13ce',

    ];
});
$factory->afterCreating(Admin::class, function($admin,$faker){
    $roles = Roles::where('name','user')->get();
    $admin->roles()->sync($roles->pluck('id_roles')->toArray());
});
