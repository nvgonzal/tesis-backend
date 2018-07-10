<?php

use Faker\Generator as Faker;

$factory->define(App\Vehiculo::class, function (Faker $faker) {
    return [
        'patente_vehiculo'  => $faker->regexify('[A-Z]{4}-[0-9]{2}'),
        'marca'             => $faker->brand,
        'modelo'            => $faker->colorName,
        'color'             => $faker->colorName,
        'id_cliente'        =>  '1'
    ];
});
