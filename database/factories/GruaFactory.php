<?php

use Faker\Factory as Faker;

$factory->define(App\Grua::class, function () {
    $faker = Faker::create('es_ES');
    $faker->addProvider(new \carfaker\provider\Car($faker));
    return [
        'patente'   => $faker->regexify('[A-Z]{4}[0-9]{2}'),
        'tipo'      => 'levante',
        'marca'     => $faker->brand,
        'modelo'    => $faker->colorName,
        'id_empresa' => '1'
    ];
});
