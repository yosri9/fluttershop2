<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Address;
use Faker\Generator as Faker;

$factory->define(Address::class, function (Faker $faker) {
    return [
        'street_name'=> $faker->streetName,
        'street_number'=>$faker->numberBetween(1,5000),
        'city'=>$faker->city,
        'country'=>$faker->state,
        'post_code'=>$faker->postcode
    ];
});
