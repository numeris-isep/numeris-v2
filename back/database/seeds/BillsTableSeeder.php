<?php

use App\Models\Application;
use App\Models\Bill;
use App\Models\Mission;
use Illuminate\Database\Seeder;

class BillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Bill::all()->isEmpty()) {
            if (Mission::all()->isEmpty()) {
                $this->call(MissionsTableSeeder::class);
            }
            $missions = Mission::all();

            foreach ($missions as $mission) {
                $applications = $mission->applicationsWhoseStatusIs(Application::ACCEPTED);
                $rates = $mission->project->convention->rates;

                foreach ($applications as $application) {
                    foreach ($rates as $rate) {
                        $this->createBill($application, $rate);
                    }
                }
            }
        }
    }

    private function createBill($application, $rate) {
        factory(Bill::class)->create([
            'application_id'    => $application->id,
            'rate_id'           => $rate->id,
            'amount'            => mt_rand(1 * 2, 10 * 2) / 2 // random number with 0.5 step
        ]);
    }
}
