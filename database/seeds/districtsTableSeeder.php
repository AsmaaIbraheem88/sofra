<?php

use Illuminate\Database\Seeder;

class districtsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('districts')->insert([
            'name' => 'التجمع الخامس',
            'city_id' =>'1',
           
        ]);
        DB::table('districts')->insert([
           'name' => 'الرجديه',
           'city_id' =>'2',
        ]);
    }
}
