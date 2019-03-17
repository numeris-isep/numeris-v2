<?php

use App\Models\Convention;
use App\Models\Rate;
use Illuminate\Database\Seeder;

class RatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Rate::all()->isEmpty()) {
            $conventions = Convention::all();

            foreach ($conventions as $convention) {
                $this->createRates($convention);
            }
        }
    }

    private function createRates($convention)
    {
        // Create 2 rates
        factory(Rate::class, 2)->create([
            'convention_id' => $convention->id
        ]);

        // Create 1 flat rate
        factory(Rate::class)->state('flat-rate')->create([
            'convention_id' => $convention->id
        ]);
    }
}
