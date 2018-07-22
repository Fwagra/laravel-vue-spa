<?php

use App\User;
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
            'name'      =>  'Root',
            'email'     =>  'root@example.com',
            'password'  =>  bcrypt('root')
        ]);
        User::create([
            'name'      =>  'Alfred',
            'email'     =>  'alfred@example.com',
            'password'  =>  bcrypt('alfred')
        ]);
        User::create([
            'name'      =>  'Bérénice',
            'email'     =>  'berenice@example.com',
            'password'  =>  bcrypt('berenice')
        ]);
    }
}
