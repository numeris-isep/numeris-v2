<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ClientsTableSeeder::class);
        $this->call(ConventionsTableSeeder::class);
        $this->call(ProjectsTableSeeder::class);
        $this->call(MissionsTableSeeder::class);
        $this->call(ApplicationsTableSeeder::class);
        $this->call(SocialContributionsTableSeeder::class);
        $this->call(RatesTableSeeder::class);
        $this->call(ProjectUserTableSeeder::class);
        $this->call(BillsTableSeeder::class);
        $this->call(MessagesTableSeeder::class);
    }
}
