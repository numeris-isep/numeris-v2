<?php

namespace Tests\Traits;

use App\Models\Client;
use App\Models\Convention;
use App\Models\Mission;
use App\Models\Project;

trait ClientProviderTrait
{
    public function clientProvider()
    {
        $this->refreshApplication();

        return [[factory(Client::class)->create()]];
    }

    public function clientWithProjectsWithMissionsProvider()
    {
        $this->refreshApplication();

        $client = factory(Client::class)->create();
        $projects = factory(Project::class, 2)->create(['client_id' => $client->id]);

        factory(Convention::class)->create(['client_id' => $client->id]);

        foreach ($projects as $project) {
            factory(Mission::class, 2)->create(['project_id' => $project->id]);
        }

        return [[$client]];
    }
}
