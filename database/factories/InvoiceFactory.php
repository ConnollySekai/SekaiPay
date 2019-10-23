<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Invoice;
use Faker\Generator as Faker;

$factory->define(Invoice::class, function (Faker $faker) {
    return [
        'contract_id' => md5(uniqid(rand(), true)),
        'business_name' => $faker->company(),
        'business_email' => $faker->unique()->safeEmail,
        'business_contact_number' => $faker->e164PhoneNumber(),
        'btc_address' => '1BoatSLRHtKNngkdXEeobR76b53LETtpyT',
        'client_name' => $faker->name(),
        'client_email' => $faker->unique()->safeEmail,
        'client_contact_number' => $faker->e164PhoneNumber(),
        'notes' => $faker->text()
    ];
});
