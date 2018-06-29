<?php

use Illuminate\Database\Seeder;

class GruasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Grua::class,5)->create();
    }
}
