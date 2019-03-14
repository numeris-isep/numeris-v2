<?php

use App\Models\SocialContribution;
use Illuminate\Database\Seeder;

class SocialContributionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (SocialContribution::all()->isEmpty()) {
            // CSG + RDS non déductibles
            factory(SocialContribution::class)->create([
                'name'          => 'CSG + RDS non déductibles',
                'student_rate'  => 2.90,
                'employer_rate' => 0.00,
            ]);

            // Assurance Vieillesse plaf.
            factory(SocialContribution::class)->create([
                'name'          => 'Assurance Vieillesse plaf.',
                'student_rate'  => 6.90,
                'employer_rate' => 8.55,
            ]);

            // Allocations Familiales
            factory(SocialContribution::class)->create([
                'name'          => 'Allocations Familiales',
                'student_rate'  => 0,
                'employer_rate' => 5.40,
            ]);

            // Contribution Dialogue Social
            factory(SocialContribution::class)->create([
                'name'          => 'Contribution Dialogue Social',
                'student_rate'  => 0,
                'employer_rate' => 0.02,
            ]);

            // Accidents du travail
            factory(SocialContribution::class)->create([
                'name'          => 'Accidents du travail',
                'student_rate'  => 0.00,
                'employer_rate' => 1.60,
            ]);

            // CSG déductible
            factory(SocialContribution::class)->create([
                'name'          => 'CSG déductible',
                'student_rate'  => 5.10,
                'employer_rate' => 0.00,
            ]);

            // Logement / FNAL
            factory(SocialContribution::class)->create([
                'name'          => 'Logement / FNAL',
                'student_rate'  => 0.00,
                'employer_rate' => 0.10,
            ]);

            // Transports
            factory(SocialContribution::class)->create([
                'name'          => 'Transports',
                'student_rate'  => 0.00,
                'employer_rate' => 2.70,
            ]);

            // Solidarité Autonomie
            factory(SocialContribution::class)->create([
                'name'          => 'Solidarité Autonomie',
                'student_rate'  => 0.00,
                'employer_rate' => 0.30,
            ]);

            // Assurances Chômage
            factory(SocialContribution::class)->create([
                'name'          => 'Assurances Chômage',
                'student_rate'  => 2.40,
                'employer_rate' => 4.00,
            ]);

            // AGS
            factory(SocialContribution::class)->create([
                'name'          => 'AGS',
                'student_rate'  => 0.00,
                'employer_rate' => 0.03,
            ]);

            // Assurance Maladie
            factory(SocialContribution::class)->create([
                'name'          => 'Assurance Maladie',
                'student_rate'  => 0.75,
                'employer_rate' => 12.89,
            ]);

            // Assurance Vieillesse deplaf.
            factory(SocialContribution::class)->create([
                'name'          => 'Assurance Vieillesse deplaf.',
                'student_rate'  => 0.40,
                'employer_rate' => 1.90,
            ]);
        }
    }
}
