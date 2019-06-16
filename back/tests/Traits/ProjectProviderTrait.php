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

trait ProjectProviderTrait
{
    public function projectProvider(): Project
    {
        return factory(Project::class)->state(Project::HIRING)->create([
            'start_at' => now()->addMonth(),
        ]);
    }

    public function privateProjectProvider(): Project
    {
        return factory(Project::class)->states(['private', Project::HIRING])->create([
            'start_at' => now()->addMonth(),
        ]);
    }

    public function hiringProjectAndAvailableMissionProvider(): array
    {
        $project = factory(Project::class)->state(Project::HIRING)->create([
            'start_at' => now()->addMonth(),
        ]);
        $mission = factory(Mission::class)->create([
            'project_id' => $project->id,
        ]);

        return [
            'project'   => $project,
            'mission'   => $mission
        ];
    }

    public function validatedProjectAndAvailableMissionProvider(): array
    {
        $project = factory(Project::class)->state(Project::VALIDATED)->create([
            'start_at' => now()->addMonth(),
        ]);
        $mission = factory(Mission::class)->create([
            'project_id' => $project->id,
        ]);

        return [
            'project'   => $project,
            'mission'   => $mission
        ];
    }

    public function publicProjectAndUserProvider(): array
    {
        return [
            'project'   => factory(Project::class)->state(Project::HIRING)
                ->create(['start_at' => now()->addMonth()]),
            'user'      => factory(User::class)->state('active')->create()
        ];
    }

    public function privateProjectAndUserProvider(): array
    {
        return [
            'project'   => factory(Project::class)->states(['private', Project::HIRING])
                ->create(['start_at' => now()->addMonth()]),
            'user'      => factory(User::class)->state('active')->create()
        ];
    }

    public function privateProjectAndUserInProjectProvider(): array
    {
        $project = factory(Project::class)->states(['private', Project::HIRING])->create([
            'start_at' => now()->addMonth(),
        ]);
        $user = factory(User::class)->state('active')->create();
        $project->addUser($user);

        return [
            'project'   => $project,
            'user'      => $user,
        ];
    }
}
