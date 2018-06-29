<?php

use Faker\Factory as Faker;
use \Freshwork\ChileanBundle\Rut;

$factory->define(App\Empresa::class, function () {
    $faker = Faker::create('es_ES');
    $nombreEmpresa = $faker->company;
    return [
        'nombre'        => $nombreEmpresa,
        'razon_social'  => $nombreEmpresa,
        'rut'           => Rut::set($faker->numberBetween(40000000,70000000))->fix()->format(),
        'direccion'     => $faker->address,
        'cuenta_pago'   => $faker->creditCardNumber
    ];
});
