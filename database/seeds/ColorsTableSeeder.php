<?php

use Illuminate\Database\Seeder;

class ColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('colors')->insert([
        	'name_color' => 'den',
        	'status' => 1,
        	'description' => 'mau den',
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_at' => null,
        ]);
    }
}
