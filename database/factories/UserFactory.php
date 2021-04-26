<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Buihuycuong\Vnfaker\VNFaker;
use Illuminate\Support\Str;


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

$factory->define(User::class, function (Faker $faker) {
    $firtname = vnfaker()->firstame();
    $lastname = vnfaker()->lastname();
    $midname = vnfaker()->midname();
    $fullname = $lastname." ".$midname." ".$firtname;
    $now = Carbon::now();
    $random = vnfaker()->numberBetween($min = 10, $max = 20);
    return [
        'fullname'=>$fullname,
//        'name' => $faker->name,
        'name'=> $faker->userName,
        'email' => $faker->unique()->safeEmail,
        // 'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'phone'=> vnfaker()->mobilephone($numbers = 10),
        'gender'=> vnfaker()->gender(),
        'birthday' => $now->subYear($random)
        // 'remember_token' => Str::random(10),
    ];
});
