<?php

use App\Models\Application;
use App\Models\Mission;
use App\Models\User;
use Illuminate\Database\Seeder;

class ApplicationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Application::all()->isEmpty()) {
            if (User::all()->isEmpty()) {
                $this->call(UsersTableSeeder::class);
            }

            if (Mission::all()->isEmpty()) {
                $this->call(MissionsTableSeeder::class);
            }

            $users = User::all()->slice(0, 14);
            $missions = Mission::findByClientName('AS Connect');

            foreach ($users as $user) {
                foreach ($missions as $mission) {
                    factory(Application::class)->create([
                        'user_id'       => $user->id,
                        'mission_id'    => $mission->id,
                        'created_at'    => $mission->start_at,
                    ]);
                }
            }
        }
    }
}
