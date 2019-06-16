<?php

namespace Tests\Traits;

use App\Models\Application;
use App\Models\Mission;
use App\Models\Project;
use App\Models\User;

trait MissionProviderTrait
{
    public function availableMissionProvider(): Mission
    {
        return factory(Mission::class)->state('available')->create();
    }

    public function availableMissionAndUserProvider(): array
    {
        return [
            'mission'   => factory(Mission::class)->state('available')->create(),
            'user'      => factory(User::class)->create(),
        ];
    }

    public function availableMissionAndUserWhoAlreadyAppliedProviderProvider(): array
    {
        $mission = factory(Mission::class)->state('available')->create();
        $user = factory(User::class)->create();

        factory(Application::class)->create([
            'mission_id'    => $mission->id,
            'user_id'       => $user->id,
        ]);

        return [
            'mission'   => $mission,
            'user'      => $user,
        ];
    }

    public function lockedMissionAndUserProvider(): array
    {
        return [
            'mission'   => factory(Mission::class)->state('locked')->create(),
            'user'      => factory(User::class)->state('active')->create(),
        ];
    }

    public function pastMissionAndUserProvider(): array
    {
        return [
            'mission'   => factory(Mission::class)->state('past')->create(),
            'user'      => factory(User::class)->state('active')->create(),
        ];
    }

    public function availablePrivateMissionAndUserProvider(): array
    {
        $project = factory(Project::class)->states(['private', Project::HIRING])->create();

        return [
            'mission'   => factory(Mission::class)->create(['project_id' => $project->id]),
            'user'      => factory(User::class)->state('active')->create(),
        ];
    }

    public function availablePrivateMissionAndUserInPrivateProjectProvider(): array
    {
        $project = factory(Project::class)->states(['private', Project::HIRING])->create();
        $user = factory(User::class)->state('active')->create();
        $project->addUser($user);

        return [
            'mission'   => factory(Mission::class)->create(['project_id' => $project->id]),
            'user'      => $user,
        ];
    }
}
