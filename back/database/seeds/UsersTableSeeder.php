<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Role::all()->isEmpty()) {
            $this->call(RolesTableSeeder::class);
        }

        // Generate developer account
        if (! User::where('email', 'developer@numeris-isep.fr')->first()) {
            $this->createUser(1, 'developer', 'active', [
                'email'     => 'developer@numeris-isep.fr',
                'username'  => 'developer',
                'firstname' => 'Developer',
                'lastname'  => 'Numeris',
            ]);
        }

        // Generate administrator account
        if (! User::where('email', 'administrator@numeris-isep.fr')->first()) {
            $this->createUser(1, 'developer', 'active', [
                'email'     => 'administrator@numeris-isep.fr',
                'username'  => 'administrator',
                'firstname' => 'Administrator',
                'lastname'  => 'Numeris',
            ]);
        }

        // Generate staff account
        if (! User::where('email', 'staff@numeris-isep.fr')->first()) {
            $this->createUser(1, 'staff', 'active', [
                'email'     => 'staff@numeris-isep.fr',
                'username'  => 'staff',
                'firstname' => 'Staff',
                'lastname'  => 'Numeris',
            ]);
        }

        // Generate student account
        if (! User::where('email', 'student@numeris-isep.fr')->first()) {
            $this->createUser(1, 'student', 'active', [
                'email'     => 'student@numeris-isep.fr',
                'username'  => 'student',
                'firstname' => 'Student',
                'lastname'  => 'Numeris',
            ]);
        }

        // Generate my account ;)
        if (! User::where('email', 'eliott.de-seguier@numeris-isep.fr')->first()) {
            $this->createUser(1, 'developer', 'active', [
                'email'     => 'eliott.de-seguier@numeris-isep.fr',
                'username'  => '2Seg',
                'firstname' => 'Eliott',
                'lastname'  => 'de Séguier',
            ]);
        }

        // Generate 5 random active users
        $this->createUser(5, 'student', 'active');

        // Generate 5 random inactive users
        $this->createUser(5);

    }

    private function createUser($number = 1, $type = 'student', $state = 'inactive', $attributes = [])
    {
        if ($number <= 1) {
            return factory(User::class)->states($state)
                ->create($attributes)
                ->roles()
                ->attach(Role::where('name', $type)->first());
        } else {
            return factory(User::class, $number)->states($state)
                ->create($attributes)
                ->map(function ($user) use ($type) {
                   $user->roles()
                       ->attach(Role::where('name', $type)->first());
                });
        }
    }
}
