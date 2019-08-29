<?php

use App\Models\SocialContribution;
use Illuminate\Database\Seeder;

class SocialContributionsTableSeeder extends Seeder
{
    /**
     * Run the database_rate seeds.
     *
     * @return void
     */
    public function run()
    {
        if (SocialContribution::all()->isEmpty()) {
            // Cotisations sur la totalité du salaire
            factory(SocialContribution::class)->create([
                'name'          => 'Cotisations sur la totalité du salaire',
                'student_rate'  => 0.40,
                'employer_rate' => 13.95,
                'base_rate'     => 1,
            ]);

            // Cotisations plafonnées
            factory(SocialContribution::class)->create([
                'name'          => 'Cotisations plafonnées',
                'student_rate'  => 6.90,
                'employer_rate' => 8.55,
                'base_rate'     => 1,
            ]);

            // Chômage + AGS
            factory(SocialContribution::class)->create([
                'name'          => 'Chômage + AGS',
                'student_rate'  => 0,
                'employer_rate' => 4.20,
                'base_rate'     => 1,
            ]);

            // Retraite complémentaire + CEG T1 AG2R Agirc-Arrco
            factory(SocialContribution::class)->create([
                'name'          => 'Retraite complémentaire + CEG T1 AG2R Agirc-Arrco',
                'student_rate'  => 4.01,
                'employer_rate' => 6.01,
                'base_rate'     => 1,
            ]);

            // CSG déductible de l'impôt sur le revenu
            factory(SocialContribution::class)->create([
                'name'          => 'CSG déductible de l\'impôt sur le revenu',
                'student_rate'  => 6.80,
                'employer_rate' => 0,
                'base_rate'     => 0.9825,
            ]);

            // CSG CRDS non déductible de l'impôt sur le revenu
            factory(SocialContribution::class)->create([
                'name'          => 'CSG CRDS non déductible de l\'impôt sur le revenu',
                'student_rate'  => 2.90,
                'employer_rate' => 0,
                'base_rate'     => 0.9825,
            ]);

            // FNAL plafonné
            factory(SocialContribution::class)->create([
                'name'          => 'FNAL plafonné',
                'student_rate'  => 0,
                'employer_rate' => 0.10,
                'base_rate'     => 1,
            ]);

            // Contribution au dialogue social
            factory(SocialContribution::class)->create([
                'name'          => 'Contribution au dialogue social',
                'student_rate'  => 0,
                'employer_rate' => 0.016,
                'base_rate'     => 1,
            ]);
        }
    }
}
