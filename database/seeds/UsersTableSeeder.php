<?php

use Illuminate\Database\Seeder;
use \Freshwork\ChileanBundle\Rut;
use Illuminate\Support\Facades\DB;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('es_ES');
        $sysAdmin = [
            'nombre'        => $faker->firstName,
            'ap_paterno'    => $faker->lastName,
            'ap_materno'    => $faker->lastName,
            'nombre_completo' => $faker->name,
            'celular'       => $faker->phoneNumber,
            'telefono_fijo' => $faker->phoneNumber,
            'tipo_usuario'  => 'admin',
            'rut'           => Rut::set($faker->numberBetween(10000000,20000000))->fix()->format(),
            'email'         => 'admin@tesis.test',
            'password'      => bcrypt('123456'),
            'created_at'    => now(),
            'updated_at'    => now()
        ];

        DB::table('users')->insert($sysAdmin);

        $client = [
            'nombre'        => $faker->firstName,
            'ap_paterno'    => $faker->lastName,
            'ap_materno'    => $faker->lastName,
            'nombre_completo' => $faker->name,
            'celular'       => $faker->phoneNumber,
            'telefono_fijo' => $faker->phoneNumber,
            'tipo_usuario'  => 'cliente',
            'rut'           => Rut::set($faker->numberBetween(10000000,20000000))->fix()->format(),
            'email'         => 'cliente@tesis.test',
            'password'      => bcrypt('123456'),
            'created_at'    => now(),
            'updated_at'    => now()
        ];

        $user = new User($client);
        $user->save();

        DB::table('clientes')->insert([
            'cuenta_pagos'  => $faker->creditCardNumber,
            'id_user' => $user->id,
            'created_at'    => now(),
            'updated_at'    => now()
        ]);

        $dueño = [
        'nombre'        => $faker->firstName,
        'ap_paterno'    => $faker->lastName,
        'ap_materno'    => $faker->lastName,
            'nombre_completo' => $faker->name,
        'celular'       => $faker->phoneNumber,
        'telefono_fijo' => $faker->phoneNumber,
        'tipo_usuario'  => 'dueño',
        'rut'           => Rut::set($faker->numberBetween(10000000,20000000))->fix()->format(),
        'email'         => 'dueño@tesis.test',
        'password'      => bcrypt('123456'),
        'created_at'    => now(),
        'updated_at'    => now()
    ];

        $user = new User($dueño);
        $user->save();

        DB::table('choferes')->insert([
            'id_empresa' => '1',
            'id_user' => $user->id,
            'created_at'    => now(),
            'updated_at'    => now()
        ]);

        $piloto = [
            'nombre'        => $faker->firstName,
            'ap_paterno'    => $faker->lastName,
            'ap_materno'    => $faker->lastName,
            'nombre_completo' => $faker->name,
            'celular'       => $faker->phoneNumber,
            'telefono_fijo' => $faker->phoneNumber,
            'tipo_usuario'  => 'dueño',
            'rut'           => Rut::set($faker->numberBetween(10000000,20000000))->fix()->format(),
            'email'         => 'piloto@tesis.test',
            'password'      => bcrypt('123456'),
            'created_at'    => now(),
            'updated_at'    => now()
        ];

        $user = new User($piloto);
        $user->save();

        DB::table('choferes')->insert([
            'id_empresa' => '1',
            'id_user' => $user->id,
            'created_at'    => now(),
            'updated_at'    => now()
        ]);


    }
}
