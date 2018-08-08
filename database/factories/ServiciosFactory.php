<?php

use Faker\Generator as Faker;

$factory->define(\App\Servicio::class, function (Faker $faker) {
    $faker->addProvider(new \carfaker\provider\Car($faker));
    return [
        'id_cliente'        => '1',
        'alta_gama'         => $faker->boolean(30),
        'ubicacion'         => $faker->longitude.' '. $faker->latitude,
        'destino'           => $faker->longitude.' '. $faker->latitude,
        'id_empresa'        => '1',
        'id_chofer'         => '1',
        'id_grua'           => '1',
        'id_vehiculo'       => function (){
            return factory(App\Vehiculo::class)->create()->id;
        },
        'descipcion'        => $faker->paragraph(),
    ];
});
