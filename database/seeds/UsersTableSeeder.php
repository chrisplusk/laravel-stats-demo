<?php

use Illuminate\Database\Seeder;

use \App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(   [
                                'name'      => 'guest',
                                'email'     => str_random(10).'@gmail.com',
                                'password'  => bcrypt('guest'),
                                ] );
        User::create(   [
                                'name'      => 'admin',
                                'email'     => str_random(10).'@gmail.com',
                                'password'  => bcrypt('admin'),
                                'admin' => true
                                ] );
    }
}
