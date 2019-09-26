<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    private $empty_table = false;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (User::all()->isEmpty()) {
            if (Role::all()->isEmpty()) {
                $this->call(RolesTableSeeder::class);
            }

            if (User::all()->isEmpty()) {
                $this->empty_table = true;
            }

            // Generate my account ;)
            if (! User::where('email', 'eliott.de-seguier@isep.fr')->first()) {
                $this->createUser(1, Role::DEVELOPER, 'active', [
                    'email'             => 'eliott.de-seguier@isep.fr',
                    'first_name'        => 'Eliott',
                    'last_name'         => 'de Séguier',
                    'promotion'         => '2019',
                    'phone'             => '0663670680',
                    'nationality'       => 'france',
                    'birth_date'        => '1995-06-29 00:00:00',
                    'birth_city'        => 'Paris'
                ]);
            }

            // Generate 2 developer accounts
            if (! User::where('email', 'developer@isep.fr')->first()) {
                $this->createUser(1, Role::DEVELOPER, 'active', [
                    'email'         => 'developer@isep.fr',
                    'first_name'    => 'Developer',
                    'last_name'     => 'Numeris',
                ]);
            }

            if (! User::where('email', 'developer2@isep.fr')->first()) {
                $this->createUser(1, Role::DEVELOPER, 'active', [
                    'email'         => 'developer2@isep.fr',
                    'first_name'    => 'Developer2',
                    'last_name'     => 'Numeris',
                ]);
            }

            // Generate 2 administrator accounts
            if (! User::where('email', 'administrator@isep.fr')->first()) {
                $this->createUser(1, Role::ADMINISTRATOR, 'active', [
                    'email'         => 'administrator@isep.fr',
                    'first_name'    => 'Administrator',
                    'last_name'     => 'Numeris',
                ]);
            }

            if (! User::where('email', 'administrator2@isep.fr')->first()) {
                $this->createUser(1, Role::ADMINISTRATOR, 'active', [
                    'email'         => 'administrator2@isep.fr',
                    'first_name'    => 'Administrator2',
                    'last_name'     => 'Numeris',
                ]);
            }

            // Generate 2 staff accounts
            if (! User::where('email', 'staff@isep.fr')->first()) {
                $this->createUser(1, Role::STAFF, 'active', [
                    'email'         => 'staff@isep.fr',
                    'first_name'    => 'Staff',
                    'last_name'     => 'Numeris',
                ]);
            }

            if (! User::where('email', 'staff2@isep.fr')->first()) {
                $this->createUser(1, Role::STAFF, 'active', [
                    'email'         => 'staff2@isep.fr',
                    'first_name'    => 'Staff2',
                    'last_name'     => 'Numeris',
                ]);
            }

            // Generate 2 student accounts
            if (! User::where('email', 'student@isep.fr')->first()) {
                $this->createUser(1, Role::STUDENT, 'active', [
                    'email'         => 'student@isep.fr',
                    'first_name'    => 'Student',
                    'last_name'     => 'Numeris',
                ]);
            }

            if (! User::where('email', 'student2@isep.fr')->first()) {
                $this->createUser(1, Role::STUDENT, 'active', [
                    'email'         => 'student2@isep.fr',
                    'first_name'    => 'Student2',
                    'last_name'     => 'Numeris',
                ]);
            }

            if ($this->empty_table) {
                // Generate 5 random active users
                $this->createUser(5, Role::STUDENT, 'active');

                // Generate 5 random inactive users
                $this->createUser(5);
            }
        }
    }

    private function createUser($number = 1, $type = Role::STUDENT, $state = 'inactive', $attributes = [])
    {
        if ($number <= 1) {
            return factory(User::class)->states($state)
                ->create($attributes)
                ->roles()
                ->attach(Role::findByName($type));
        } else {
            return factory(User::class, $number)->states($state)
                ->create($attributes)
                ->map(function ($user) use ($type) {
                   $user->roles()
                       ->attach(Role::findByName($type));
                });
        }
    }
}
