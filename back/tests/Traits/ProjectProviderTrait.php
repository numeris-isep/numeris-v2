<?php

namespace Tests\Traits;

use App\Models\Mission;
use App\Models\Project;

trait ProjectProviderTrait
{
    public function hiringProjectAndAvailableMissionProvider()
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

    public function validatedProjectAndAvailableMissionProvider()
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
}
