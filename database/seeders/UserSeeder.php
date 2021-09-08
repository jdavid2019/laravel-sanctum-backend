<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
         ['name' => 'joseph', 'email' => 'joseph2019@gmail.com' , 'password' => bcrypt('joseph')]
        ];

        foreach($data as $value) {
            DB::table('users')->insert([
               'name' => $value['name'],
               'email' => $value['email'],
               'password' => $value['password']
            ]);
        }
    }
}
