<?php

namespace Tests\Traits;

use App\Models\Application;
use App\Models\Bill;
use App\Models\Client;
use App\Models\Convention;
use App\Models\Mission;
use App\Models\Project;
use App\Models\Rate;
use App\Models\User;

trait ConventionProviderTrait
{
    public function conventionProvider()
    {
        $this->refreshApplication();

        $client = factory(Client::class)->create();
        $convention = factory(Convention::class)->create([
            'client_id' => $client->id
        ]);
        factory(Rate::class)->create([
            'convention_id' => $convention->id
        ]);
        factory(Rate::class)->state('flat-rate')->create([
            'convention_id' => $convention->id
        ]);

        return [[$convention]];
    }

    public function conventionAndProjectProvider()
    {
        $this->refreshApplication();

        $client = factory(Client::class)->create();
        $convention = factory(Convention::class)->create(['client_id' => $client->id]);

        factory(Rate::class)->create(['convention_id' => $convention->id]);
        factory(Rate::class)->state('flat-rate')->create(['convention_id' => $convention->id]);

        $project = factory(Project::class)->create([
            'client_id'     => $client->id,
            'convention_id' => $convention->id,
        ]);

        return [[$convention, $project]];
    }

    public function conventionWithRatesWithBillsProvider()
    {
        $this->refreshApplication();

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

        return [[$convention]];
    }
}
