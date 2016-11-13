<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Appointment;
use App\Patient;

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Patient::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'date_of_birth' => $faker->dateTimeBetween('-23 years', '-18 years'),
        'created_at' => $faker->dateTimeBetween('-8 month', '-1 month'),
        'updated_at' => $faker->dateTimeBetween('-8 month', '-1 month')
    ];
});


$factory->define(App\Appointment::class, function (Faker\Generator $faker) use ($factory) {
    $patientId = Patient::first() ? Patient::first()->id : $factory->create(Patient::class);
    return [
        'patient_id' => $patientId,
        'appointment_date' => $faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
        'status' => [Appointment::STATUS_SCHEDULED, Appointment::STATUS_CANCELED, Appointment::STATUS_NOSHOW, Appointment::STATUS_COMPLETE][rand(0, 3)]
    ];
});
