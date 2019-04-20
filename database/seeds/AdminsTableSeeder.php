<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <= 10 ; $i++) { 
        	DB::table('admins')->insert([
        		'username' => Str::random(5),
        		'password' => Str::random(10),
        		'email' => Str::random(10).'@gmail.com',
        		'role' => 1,
        		'status' => 1,
        		'avatar' => null,
        		'phone' => '1623816823',
        		'address' => 'Ha Noi',
        		'created_at' => date('Y-m-d H:i:s'),
        		'updated_at' => null,
        	]);
        }
    }
}
