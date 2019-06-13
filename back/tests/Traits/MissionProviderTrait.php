<?php

namespace Tests\Traits;

use App\Models\Application;
use App\Models\Mission;
use App\Models\Project;
use App\Models\User;

trait MissionProviderTrait
{
    public function availableMissionProvider()
    {
        $this->refreshApplication();

        return [[factory(Mission::class)->state('available')->create()]];
    }

    public function availableMissionAndUserProvider()
    {
        $this->refreshApplication();

        return [[
            factory(Mission::class)->state('available')->create(),
            factory(User::class)->create(),
        ]];
    }

    public function availableMissionAndUserWhoAlreadyAppliedProviderProvider()
    {
        $this->refreshApplication();

        $mission = factory(Mission::class)->state('available')->create();
        $user = factory(User::class)->create();

        factory(Application::class)->create([
            'mission_id'    => $mission->id,
            'user_id'       => $user->id,
        ]);

        return [[$mission, $user]];
    }

    public function lockedMissionAndUserProvider()
    {
        $this->refreshApplication();

        return [[
            factory(Mission::class)->state('locked')->create(),
            factory(User::class)->state('active')->create(),
        ]];
    }

    public function pastMissionAndUserProvider()
    {
        $this->refreshApplication();

        return [[
            factory(Mission::class)->state('past')->create(),
            factory(User::class)->state('active')->create(),
        ]];
    }

    public function availablePrivateMissionAndUserProvider()
    {
        $this->refreshApplication();

        $project = factory(Project::class)->states(['private', Project::HIRING])->create();

        return [[
            factory(Mission::class)->create(['project_id' => $project->id]),
            factory(User::class)->state('active')->create(),
        ]];
    }

    public function availablePrivateMissionAndUserInPrivateProjectProvider()
    {
        $this->refreshApplication();

        $project = factory(Project::class)->states(['private', Project::HIRING])->create();
        $user = factory(User::class)->state('active')->create();
        $project->addUser($user);

        return [[
            factory(Mission::class)->create(['project_id' => $project->id]),
            $user,
        ]];
    }
}
