<?php

use Faker\Generator as Faker;

$factory->define(\App\Servicio::class, function (Faker $faker) {
    $faker->addProvider(new \carfaker\provider\Car($faker));
    return [
        'id_cliente'        => '1',
        'alta_gama'         => $faker->boolean(30),
        'patente_vehiculo'  => $faker->regexify('[A-Z]{4}-[0-9]{2}'),
        'marca'             => $faker->brand,
        'modelo'            => $faker->colorName,
        'color'             => $faker->colorName,
        'ubicacion'         => $faker->longitude.' '. $faker->latitude,
        'destino'           => $faker->longitude.' '. $faker->latitude,
        'id_empresa'        => '1',
        'id_chofer'         => '1',
        'id_grua'           => '1'
    ];
});
