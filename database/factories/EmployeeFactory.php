<?php

use App\Models\Employee;
use App\Models\Position;
use Faker\Generator as Faker;


$factory->define(Employee::class, function (Faker $faker) {
    $roundValidator = function($digit) {
        return $digit % 10 === 0;
    };

    $number = $faker->unique()->randomNumber(6);
    $imageDirectory = 'employees_photos\\';
    $smallImageDirectory = 'small_employees_photos\\';
//    $imageUrl =  $faker->randomElement(['300x300.png', '300x350.png']);
    $imageUrl = $faker->imageUrl(300,300, 'people');
    return [
        'name' => $faker->firstName.' '.$faker->lastName,
        'position' => Position::all()->random()->name,
        'date_of_employment' => $faker->dateTimeThisDecade('now'),
        'phone_number' => '+380'. ' ('.$faker->randomNumber(2).') '.
                                        $faker->randomNumber(3) . ' '.
                                        $faker->randomNumber(2). ' '.
                                        $faker->randomNumber(2),
        'email' => $faker->unique()->safeEmail,
        'salary' => $faker->valid($roundValidator)->numberBetween(100, 500),
//        'photo' => $imageDirectory.$faker->image('public/storage/employees_photos',300,300, 'people', false),
        'small_photo' => $imageUrl,
        'photo' => $imageUrl,
        'type_photo' => 'url',
        'admin_created_id' => $number,
        'admin_updated_id' => $number,
    ];
});
