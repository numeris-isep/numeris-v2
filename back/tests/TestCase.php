<?php

namespace Tests;

use App\Models\Contact;
use App\Models\Mission;
use App\Models\Project;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication,
        WithoutMiddleware,
        DatabaseTransactions;

    public function hiringProjectWithAvailableMissionProvider()
    {
        $this->refreshApplication();

        $project = factory(Project::class)->create([
            'step'      => Project::HIRING,
            'start_at'  => now()->addMonth(),
        ]);
        $mission = factory(Mission::class)->create([
            'project_id'    => $project->id,
        ]);

        return [[$project, $mission]];
    }

    public function validatedProjectWithAvailableMissionProvider()
    {
        $this->refreshApplication();

        $project = factory(Project::class)->create([
            'step'      => Project::VALIDATED,
            'start_at'  => now()->addMonth(),
        ]);
        $mission = factory(Mission::class)->create([
            'project_id'    => $project->id,
        ]);

        return [[$project, $mission]];
    }

    public function clientContactProvider()
    {
        $this->refreshApplication();

        return [[factory(Contact::class)->create()]];
    }
}
