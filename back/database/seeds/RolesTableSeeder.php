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
                'developer' => 1,
                'administrator' => 2,
                'staff' => 3,
                'student' => 4,
            ];

            foreach ($roles as $name => $hierarchy) {
                factory(Role::class)->create([
                    'name' => $name,
                    'hierarchy' => $hierarchy,
                ]);
            }
        }
    }
}
