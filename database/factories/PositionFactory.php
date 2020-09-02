<?php

use App\Models\Position;
use Faker\Generator as Faker;

$factory->define(Position::class, function (Faker $faker) {
    $number = $faker->unique()->randomNumber(6);
    return [
        'name' => $faker->jobTitle,
        'admin_created_id' => $number,
        'admin_updated_id' => $number,
    ];
});
