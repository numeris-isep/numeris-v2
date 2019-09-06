<?php

use App\Models\Client;
use App\Models\Contact;
use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Client::all()->isEmpty()) {
            if (! Client::where('name', 'AS Connect')->first()) {
                factory(Client::class)->create(['name' => 'AS Connect']);
            }

            if (! Client::where('name', 'AS International')->first()) {
                factory(Client::class)->create(['name' => 'AS International']);
            }

            if (! Client::where('name', 'Infodis')->first()) {
                factory(Client::class)->create(['name' => 'Infodis']);
            }

            if (! Client::where('name', 'Métalogic')->first()) {
                factory(Client::class)->create(['name' => 'Métalogic']);
            }

            if (! Client::where('name', 'ISEP')->first()) {
                factory(Client::class)->create(['name' => 'ISEP']);
            }

            if (! Client::where('name', 'SRID Informatique')->first()) {
                factory(Client::class)->create(['name' => 'SRID Informatique']);
            }
        }
    }
}
