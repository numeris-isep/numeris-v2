<?php

namespace Tests\Traits;

use App\Models\Application;
use App\Models\Bill;
use App\Models\Client;
use App\Models\Contact;
use App\Models\Convention;
use App\Models\Mission;
use App\Models\Project;
use App\Models\Rate;
use App\Models\User;

trait ClientProviderTrait
{
    public function clientProvider(): Client
    {
        return factory(Client::class)->create();
    }

    public function clientContactProvider(): Client
    {
        return factory(Contact::class)->create();
    }

    public function clientWithProjectsWithMissionsProvider(): Client
    {
        $client = factory(Client::class)->create();
        $projects = factory(Project::class, 2)->create(['client_id' => $client->id]);

        factory(Convention::class)->create(['client_id' => $client->id]);

        foreach ($projects as $project) {
            factory(Mission::class, 2)->create(['project_id' => $project->id]);
        }

        return $client;
    }

    public function clientAndProjectAndMissionAndConventionWithBillsProvider(): array
    {
        $client = factory(Client::class)->create();
        $convention = factory(Convention::class)->create(['client_id' => $client->id]);

        $rate = factory(Rate::class)->create(['convention_id' => $convention->id]);
        $flat_rate = factory(Rate::class)->state('flat-rate')->create(['convention_id' => $convention->id]);

        $project = factory(Project::class)->create([
            'client_id'     => $client->id,
            'convention_id' => $convention->id,
        ]);
        $mission = factory(Mission::class)->create(['project_id' => $project->id]);
        $user = factory(User::class)->create();
        $application = factory(Application::class)->create([
            'mission_id'    => $mission->id,
            'user_id'       => $user->id,
        ]);

        factory(Bill::class)->create([
            'application_id'    => $application->id,
            'rate_id'           => $rate->id,
        ]);
        factory(Bill::class)->create([
            'application_id'    => $application->id,
            'rate_id'           => $flat_rate->id,
        ]);

        return [
            'client'        => $client,
            'project'       => $project,
            'mission'       => $mission,
            'convention'    => $convention,
            'rate'          => $rate,
        ];
    }
}
