<?php

use App\Models\Client;
use App\Models\Contact;
use App\Models\Mission;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Mission::flushEventListeners();

        if (Mission::all()->isEmpty()) {
            if (Project::all()->isEmpty()) {
                $this->call(ProjectsTableSeeder::class);
            }

            if (User::all()->isEmpty()) {
                $this->call(UsersTableSeeder::class);
            }

            $this->createMissions();
        }
    }

    private function createMissions()
    {
        $clients = Client::all();

        foreach ($clients as $client) {
            $projects = $client->projects;

            foreach ($projects as $project) {
                $this->createThreeMissionTypes($project);
            }
        }
    }

    private function createThreeMissionTypes($project)
    {
        // Déconnexion
        factory(Mission::class)->create([
            'project_id'    => $project->id,
            'user_id'       => User::find(1),
            'contact_id'    => Contact::find(1),
            'title'         => "Déconnexion {$project->name}",
            'start_at'      => Carbon::parse($project->start_at)->addDays(4),
        ]);

        // Reconnexion
        factory(Mission::class)->create([
            'project_id'    => $project->id,
            'user_id'       => User::find(2),
            'contact_id'    => Contact::find(2),
            'title'         => "Reconnexion {$project->name}",
            'start_at'      => Carbon::parse($project->start_at)->addDays(11),
        ]);

        // SAV
        factory(Mission::class)->state('locked')->create([
            'project_id'    => $project->id,
            'user_id'       => User::find(3),
            'contact_id'    => null,
            'title'         => "SAV {$project->name}",
            'start_at'      => Carbon::parse($project->start_at)->addDays(19),
        ]);
    }
}
