<?php

namespace Tests;

use App\Models\Mission;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Carbon;

abstract class TestCaseWithAuth extends TestCase
{
    protected $username;

    protected $hiringProject;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::where('username', $this->username)->first();

        auth()->claims(['rol' => $user->role()->name])
            ->attempt([
                'email' => $user->email,
                'password' => 'azerty'
            ]);
    }

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
}
