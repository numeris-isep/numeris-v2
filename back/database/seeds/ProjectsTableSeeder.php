<?php

use App\Models\Client;
use App\Models\Convention;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Project::all()->isEmpty()) {
            if (Client::all()->isEmpty()) {
                $this->call(ClientsTableSeeder::class);
            }
            if (Convention::all()->isEmpty()) {
                $this->call(ConventionsTableSeeder::class);
            }

            // AS Connect
            $as_connect = Client::findByName('AS Connect');
            $this->createProjects($as_connect);

            // AS International
            $as_inter = Client::findByName('AS International');
            $this->createProjects($as_inter);

            // Infodis
            $infodis = Client::findByName('Infodis');
            $this->createProjects($infodis);

            // Métalogic
            $metalogic = Client::findByName('Métalogic');
            $this->createProjects($metalogic);

            // ISEP
            $isep = Client::findByName('ISEP');
            $this->createProjects($isep);

            // SRID Informatique
            $srid = Client::findByName('SRID Informatique');
            $this->createProjects($srid);
        }
    }

    private function createProjects($client)
    {
        $months = [
            '01' => 'Janvier',
            '02' => 'Février',
            '03' => 'Mars',
            '04' => 'Avril',
            '05' => 'Mai',
            '06' => 'Juin',
            '07' => 'Juillet',
            '08' => 'Août',
            '09' => 'Septembre',
            '10' => 'Octobre',
            '11' => 'Novembre',
            '12' => 'Décembre',
        ];

        foreach ($months as $month_number => $month_name) {
            factory(Project::class)
                ->create([
                    'client_id'         => $client->id,
                    'convention_id'     => $client->conventions()->first()->id,
                    'name'              => "{$client->name} $month_name 2018",
                    'start_at'          => "2018/$month_number/01 00:00:00",
                    'money_received_at' => "2018/$month_number/25 00:00:00",
                    'is_private'        => $month_number == '12',
                ]);
        }

        // This month
        factory(Project::class)
            ->create([
                'client_id'         => $client->id,
                'convention_id'     => $client->conventions()->first()->id,
                'name'              => "{$client->name} " . Carbon::now()->format('F Y'),
                'start_at'          => Carbon::now()->toDateTimeString(),
                'money_received_at' => Carbon::now()->toDateTimeString(),
                'is_private'        => false,
            ]);

        // Next month
        factory(Project::class)
            ->create([
                'client_id'         => $client->id,
                'convention_id'     => $client->conventions()->first()->id,
                'name'              => "{$client->name} " . Carbon::now()->addMonth()->format('F Y'),
                'start_at'          => Carbon::now()->addMonth()->toDateTimeString(),
                'money_received_at' => Carbon::now()->addMonth()->toDateTimeString(),
                'is_private'        => true,
            ]);
    }
}
