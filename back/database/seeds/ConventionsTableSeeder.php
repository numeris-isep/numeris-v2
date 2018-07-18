<?php

use App\Models\Client;
use App\Models\Convention;
use Illuminate\Database\Seeder;

class ConventionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ($client = Client::where('name', 'AS Connect')->first()) {
            $client->conventions()
                ->saveMany(factory(Convention::class, 2)->create());
        }

        if ($client = Client::where('name', 'AS International')->first()) {
            $client->conventions()
                ->saveMany(factory(Convention::class, 2)->create());
        }

        if ($client = Client::where('name', 'Infodis')->first()) {
            $client->conventions()
                ->saveMany(factory(Convention::class, 2)->create());
        }

        if ($client = Client::where('name', 'Métalogic')->first()) {
            $client->conventions()
                ->saveMany(factory(Convention::class, 2)->create());
        }

        if ($client = Client::where('name', 'ISEP')->first()) {
            $client->conventions()
                ->saveMany(factory(Convention::class, 2)->create());
        }

        if ($client = Client::where('name', 'SRID Informatique')->first()) {
            $client->conventions()
                ->saveMany(factory(Convention::class, 2)->create());
        }
    }
}
