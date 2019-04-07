<?php

use App\Models\Project;
use App\Models\User;
use App\ProjectUser;
use Illuminate\Database\Seeder;

class ProjectUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! (User::all()->isEmpty() && Project::all()->isEmpty())
            && ProjectUser::all()->isEmpty()
        ) {
            $user = User::find(1);
            $projects = Project::private();

            foreach ($projects as $project) {
                $project->users()->attach($user);
            }
        }
    }
}
