<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->truncate(); // truncate user table each time of seeders run
        User::create([ // create a new user
            'email' => 'admin@designhouse.com',
            'password' => Hash::make('password'),
            'name' => 'Admin',
            'username' => 'Admin',
            'email_verified_at' => now(),
        ]);
        User::create([ // create a new user
            'email' => 'jessica@designhouse.com',
            'password' => Hash::make('password'),
            'name' => 'Jessica Bujazia',
            'username' => 'jessicajeanbujazia',
            'email_verified_at' => now(),
        ]);
    }
}
