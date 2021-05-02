<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VaccinationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vaccination = \App\Models\Vaccination::all()->first();
        $vaccination->save();
        $user1 = new \App\Models\User;

        $user1->firstName = 'Atom';
        $user1->lastName = 'Eve';
        $user1->phone = '06604806950';
        $user1->email = 'atomeve@hero.io';
        $user1->ssn = '5859060696';
        $user1->sex = 'f';
        $user1->isAdmin = false;
        $user1->isVaccinated = false;
        $user1->password = bcrypt('secret');


        $user2 = new \App\Models\User;
        $user2->firstName = 'Monster';
        $user2->lastName = 'Girl';
        $user2->phone = '06601206950';
        $user2->email = 'monstergirl@hero.io';
        $user2->ssn = '5859070796';
        $user2->sex = 'f';
        $user2->isAdmin = false;
        $user2->isVaccinated = false;
        $user2->password = bcrypt('secret');


        $vaccination->users()->saveMany([$user1, $user2]);
        //$vaccination->save();

        //
    }
}
