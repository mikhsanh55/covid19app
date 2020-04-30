<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker = Faker::create('id_ID');

    	for($i = 0;$i < 20;$i++) {
    		DB::table('user')->insert([
    			'username' => $faker->name(),
	        	'email' => $faker->unique()->safeEmail,
	        	'password' => password_hash($faker->name, PASSWORD_DEFAULT)
	        ]);
    	}
	        
    }
}
