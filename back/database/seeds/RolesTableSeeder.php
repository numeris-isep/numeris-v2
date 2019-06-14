<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Role::all()->isEmpty()) {
            // 'name', 'name_fr', 'hierarchy'
            $roles = [
                [Role::DEVELOPER,       'Développeur',      1],
                [Role::ADMINISTRATOR,   'Administrateur',   2],
                [Role::STAFF,           'Staff',            3],
                [Role::STUDENT,         'Étudiant',         4],
            ];

            foreach ($roles as $role) {
                factory(Role::class)->create([
                    'name'      => $role[0],
                    'name_fr'   => $role[1],
                    'hierarchy' => $role[2],
                ]);
            }
        }
    }
}
