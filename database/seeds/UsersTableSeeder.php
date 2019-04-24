<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'     => 'Cristian Fernando Alvarez Trujillo',
            'email'    => 'juancagb.17@gmail.com',
            'password' => bcrypt('123123'),
            'admin'    => true,
        ]);
    }
}
