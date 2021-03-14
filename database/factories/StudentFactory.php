<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Student;
use Faker\Generator as Faker;
use Buihuycuong\Vnfaker\VNFaker;

$factory->define(Student::class, function (Faker $faker) {
    $firtname = vnfaker()->firstame();
    $lastname = vnfaker()->lastname();
    $midname = vnfaker()->midname();
    $fullname = $lastname." ".$midname." ".$firtname;
    return [
        'fullname'=>$fullname,
//        'name' => $faker->name,
        'name'=> $faker->userName,
        'email' => $faker->unique()->safeEmail,
        // 'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'phone'=> vnfaker()->mobilephone($numbers = 10),
        'gender'=> vnfaker()->gender()
        // 'remember_token' => Str::random(10),
    ];
});
