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
                'email'         => 'developer@numeris-isep.fr',
                'username'      => 'developer',
                'first_name'    => 'Developer',
                'last_name'     => 'Numeris',
            ]);
        }

        // Generate administrator account
        if (! User::where('email', 'administrator@numeris-isep.fr')->first()) {
            $this->createUser(1, 'developer', 'active', [
                'email'         => 'administrator@numeris-isep.fr',
                'username'      => 'administrator',
                'first_name'    => 'Administrator',
                'last_name'     => 'Numeris',
            ]);
        }

        // Generate staff account
        if (! User::where('email', 'staff@numeris-isep.fr')->first()) {
            $this->createUser(1, 'staff', 'active', [
                'email'         => 'staff@numeris-isep.fr',
                'username'      => 'staff',
                'first_name'    => 'Staff',
                'last_name'     => 'Numeris',
            ]);
        }

        // Generate student account
        if (! User::where('email', 'student@numeris-isep.fr')->first()) {
            $this->createUser(1, 'student', 'active', [
                'email'         => 'student@numeris-isep.fr',
                'username'      => 'student',
                'first_name'    => 'Student',
                'last_name'     => 'Numeris',
            ]);
        }

        // Generate my account ;)
        if (! User::where('email', 'eliott.de-seguier@numeris-isep.fr')->first()) {
            $this->createUser(1, 'developer', 'active', [
                'email'             => 'eliottdes@gmail.com',
                'username'          => '2Seg',
                'first_name'        => 'Eliott',
                'last_name'         => 'de Séguier',
                'student_number'    => 8740,
                'promotion'         => '2019',
                'phone'             => '06 63 67 06 80',
                'nationality'       => 'Française',
                'birth_date'        => '1995-06-29 00:00:00',
                'birth_city'        => 'Paris'
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
