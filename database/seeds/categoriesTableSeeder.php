<?php

use Illuminate\Database\Seeder;

class categoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'مشاوي',
        ]);
        DB::table('categories')->insert([
           'name' => 'اسماك',
        ]);
    }
}
