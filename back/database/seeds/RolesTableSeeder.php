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
            // 'name' => 'hierarchy'
            $roles = [
                ['developer', 'Développeur', 1],
                ['administrator', 'Administrateur', 2],
                ['staff', 'Staff', 3],
                ['student', 'Étudiant', 4],
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
