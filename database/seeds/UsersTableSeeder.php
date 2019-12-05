<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(User $user)
    {
        //


  		$user->create([
	        'name' => 'admin',
	        'email' => 'ssusanthawarnapura@gmail.com',
	        'email_verified_at' => now(),
	        'password' => '$2y$10$eyduUhz81QZjWzWgjv/n3uqkAhyaoiK7LDXrpP.gDknxT396ybb0C', // password
	        'remember_token' => '29tgw9nFDT0GM5FkVtcm9Knt9FPUjlWu73hTR6V7aEl7CtHpuCJz3ZJJwNZp',
	        'created_at' => now(),
	        'updated_at' => null,
	    ]);
       
    }
}
