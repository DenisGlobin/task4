<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Document;
use Faker\Generator as Faker;

$factory->define(Document::class, function (Faker $faker) {
    return [
        'status' => 'draft',
        'payload' => json_encode([
            $faker->word => $faker->sentence,
            $faker->word => $faker->sentence,
        ], JSON_PRETTY_PRINT),
        'user_id' => rand(1, App\User::all()->count()),
    ];
});
