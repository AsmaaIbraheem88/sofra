<?php

use Illuminate\Database\Seeder;

class citiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert([
            'name' => 'مصر الجديده',
        ]);
        DB::table('cities')->insert([
           'name' => 'طنطا',
        ]);
    }
}
