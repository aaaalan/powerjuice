<?php

namespace Database\Seeders;

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
        $user = new \App\Models\User;
        $user->firstName ='Mark';
        $user->lastName ='Greyson';
        $user->email ='invincible@hero.io';
        $user->phone ='06604806529';
        $user->password = bcrypt('secret');
        $user->ssn ="5363160196";
        $user->sex ="m";
        $user->isVaccinated =false;
        $user->isAdmin =false;
        $user->save();

    }
}
