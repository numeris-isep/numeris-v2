<?php

use App\Models\Client;
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
                factory(Client::class)->create([
                    'name'      => 'AS Connect',
                    'reference' => '01-0001'
                ]);
            }

            if (! Client::where('name', 'AS International')->first()) {
                factory(Client::class)->create([
                    'name'      => 'AS International',
                    'reference' => '02-0002'
                ]);
            }

            if (! Client::where('name', 'Infodis')->first()) {
                factory(Client::class)->create([
                    'name'      => 'Infodis',
                    'reference' => '03-0003'
                ]);
            }

            if (! Client::where('name', 'Métalogic')->first()) {
                factory(Client::class)->create([
                    'name'      => 'Métalogic',
                    'reference' => '04-0004'
                ]);
            }

            if (! Client::where('name', 'ISEP')->first()) {
                factory(Client::class)->create([
                    'name'      => 'ISEP',
                    'reference' => '05-0005'
                ]);
            }

            if (! Client::where('name', 'SRID Informatique')->first()) {
                factory(Client::class)->create([
                    'name'      => 'SRID Informatique',
                    'reference' => '06-0006'
                ]);
            }
        }
    }
}
