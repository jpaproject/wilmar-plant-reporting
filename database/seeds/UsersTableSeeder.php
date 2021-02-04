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
        //
        // \App\User::create([
        //     'name' => 'John Doe',
        //     'email' => 'superadmin@gmail.com',
        //     'password' => bcrypt('superadmin'),
        // ]);
        factory(\App\User::class, 3)->create();
    }
}
