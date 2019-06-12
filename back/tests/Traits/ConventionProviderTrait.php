<?php

namespace Tests\Traits;

use App\Models\Client;
use App\Models\Convention;
use App\Models\Project;
use App\Models\Rate;

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

    public function conventionWithProjectProvider()
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
        $project = factory(Project::class)->create([
            'client_id'     => $client->id,
            'convention_id' => $convention->id,
        ]);

        return [[$convention, $project]];
    }
}
