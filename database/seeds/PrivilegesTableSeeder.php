<?php

use Illuminate\Database\Seeder;

class PrivilegesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            [
                'name' => 'Dashboard',
                'description' => '',
            ],
            [
                'name' => 'ViewUsers',
                'description' => '',
            ],
            [
                'name' => 'ViewDepartements',
                'description' => '',
            ]);
        \App\Privilege::insert($data);
    }
}
