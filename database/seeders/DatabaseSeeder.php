<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use function Symfony\Component\Translation\t;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LocationsTableSeeder::class);
        $this->call(VaccinationsTableSeeder::class);
        //$this->call(UsersTableSeeder::class);

        // User::factory(10)->create();
    }
}
