<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([

            'name' => 'Hardik',

            'email' => 'admin@gmail.com',

            'password' => bcrypt('123456'),
            'phone'=>'891829198',   
            'user_type' => '1'  

        ]);
    }
}
