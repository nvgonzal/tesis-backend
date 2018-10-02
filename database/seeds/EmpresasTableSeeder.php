<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EmpresasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('es_ES');
        $cuentas_paypal = [
            'empresa1@tesis.web',
            'empresa2@tesis.web',
            'empresa3@tesis.web',
            'empresa4@tesis.web',
            'empresa5@tesis.web',
        ];
        //factory(App\Empresa::class,5)->create();
        for ($i = 0; $i < 5; $i++) {
            $nombreEmpresa = $faker->company;
            $datos = [
                'nombre'        => $nombreEmpresa,
                'razon_social'  => $nombreEmpresa,
                'rut'           => Rut::set($faker->numberBetween(40000000,70000000))->fix()->format(),
                'direccion'     => $faker->address,
                'cuenta_pago'   => $cuentas_paypal[$i],
                'latitud'       => $faker->latitude(-36.781028,-36.786115),
                'longitud'      => $faker->longitude(-73.036772,-73.074881),
            ];
            $empresa = \App\Empresa::create($datos);
            $empresa->save();
        }
    }
}
