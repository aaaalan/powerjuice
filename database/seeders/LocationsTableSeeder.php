<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*DB::table('locations')->insert([
            'name' => 'Testbus Interspar',
            'street' => 'Intersparstrasse 3',
            'zipcode' => 4600,
            'city' => 'Wels',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);*/

        $location = new \App\Models\Location;
        $location->name = "Safthaus";
        $location->street = "Impfstreet 4";
        $location->zipcode = 4623;
        $location->city = "Gunskirchen";
        $location->save();

        $location = new \App\Models\Location;
        $location->name = "Saftladen";
        $location->street = "Zur Saftstation 5";
        $location->zipcode = "4614";
        $location->city = "Marchtrenk";
        $location->save();

        $location = new \App\Models\Location;
        $location->name = "Impfort";
        $location->street = "Heile Weg 1";
        $location->zipcode = 4020;
        $location->city = "Linz";
        $location->save();


        $location = new \App\Models\Location;
        $location->name = "Hero Tower";
        $location->street = "Vaccination Tower 3";
        $location->zipcode = 4600;
        $location->city = "Wels";
        $location->save();

        $vaccination1 = new \App\Models\Vaccination;
        $vaccination1->date="2015-09-22";
        $vaccination1->startTime="07:07:07";
        $vaccination1->endTime="08:08:09";
        $vaccination1->maxUsers=7;

        $vaccination2 = new \App\Models\Vaccination;
        $vaccination2->date="2021-09-22";
        $vaccination2->startTime="08:08:08";
        $vaccination2->endTime="09:09:09";
        $vaccination2->maxUsers=8;

        $location->vaccinations()->saveMany([$vaccination1,$vaccination2]);
        $location->save();

    }
}
