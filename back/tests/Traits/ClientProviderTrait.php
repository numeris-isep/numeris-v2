<?php

namespace Tests\Traits;

use App\Models\Application;
use App\Models\Bill;
use App\Models\Client;
use App\Models\Contact;
use App\Models\Convention;
use App\Models\Invoice;
use App\Models\Mission;
use App\Models\Payslip;
use App\Models\Project;
use App\Models\Rate;
use App\Models\User;

trait ClientProviderTrait
{
    public function clientProvider(): Client
    {
        return factory(Client::class)->create();
    }

    public function clientContactProvider(): Contact
    {
        return factory(Contact::class)->create();
    }

    public function clientWithProjectsWithMissionsProvider(): Client
    {
        $client = factory(Client::class)->create();
        $projects = factory(Project::class, 2)->create(['client_id' => $client->id]);

        factory(Convention::class)->create(['client_id' => $client->id]);

        foreach ($projects as $project) {
            factory(Mission::class, 2)->create(['project_id' => $project->id]);
        }

        return $client;
    }

    public function clientAndProjectAndMissionAndConventionProvider($user = null, $month = null, $project = null): array
    {
        $client = factory(Client::class)->create();
        $convention = factory(Convention::class)->create(['client_id' => $client->id]);

        $rate = factory(Rate::class)->create([
            'convention_id' => $convention->id,
            'for_student'   => 8,
            'for_staff'     => 10,
            'for_client'    => 12,
        ]);

        $project = $project ?? factory(Project::class)->state('validated')->create([
            'client_id'     => $client->id,
            'convention_id' => $convention->id,
            'start_at'      => $month ?? '2000-01-01 00:00:00',
        ]);
        $mission = factory(Mission::class)->create([
            'project_id' => $project->id,
            'start_at'   => $month ?? '2000-01-01 08:00:00',
        ]);

        $user = $user ?? factory(User::class)->state('active')->create();
        $application = factory(Application::class)->create([
            'mission_id'    => $mission->id,
            'user_id'       => $user->id,
            'status'        => Application::ACCEPTED,
        ]);

        return [
            'client'        => $client,
            'project'       => $project,
            'user'          => $user,
            'mission'       => $mission,
            'convention'    => $convention,
            'application'   => $application,
            'rate'          => $rate,
        ];
    }

    public function clientAndProjectAndMissionAndConventionWithBillsProvider($user = null, $month = null, $project = null): array
    {
        $client = factory(Client::class)->create();
        $convention = factory(Convention::class)->create(['client_id' => $client->id]);

        $rate = factory(Rate::class)->create([
            'convention_id' => $convention->id,
            'for_student'   => 8,
            'for_staff'     => 10,
            'for_client'    => 12,
        ]);
        $flat_rate = factory(Rate::class)->state('flat-rate')->create([
            'convention_id' => $convention->id,
            'for_student'   => 80,
            'for_staff'     => 100,
            'for_client'    => 120,
        ]);

        $project = $project ?? factory(Project::class)->create([
            'client_id'     => $client->id,
            'convention_id' => $convention->id,
            'start_at'      => $month ?? '2000-01-01 00:00:00',
        ]);
        $mission = factory(Mission::class)->create([
            'project_id' => $project->id,
            'start_at'   => $month ?? '2000-01-01 08:00:00',
        ]);

        $user = $user ?? factory(User::class)->state('active')->create();
        $application = factory(Application::class)->create([
            'mission_id'    => $mission->id,
            'user_id'       => $user->id,
            'status'        => Application::ACCEPTED,
        ]);

        $bill = factory(Bill::class)->create([
            'application_id'    => $application->id,
            'rate_id'           => $rate->id,
            'amount'            => 10,
        ]);
        factory(Bill::class)->create([
            'application_id'    => $application->id,
            'rate_id'           => $flat_rate->id,
            'amount'            => 1,
        ]);

        $payslip = factory(Payslip::class)->create([
            'user_id'   => $user->id,
            'month'     => $month ?? '2000-01-01 00:00:00',
        ]);

        $invoice = factory(Invoice::class)->create(['project_id' => $project->id]);

        return [
            'client'        => $client,
            'project'       => $project,
            'user'          => $user,
            'mission'       => $mission,
            'convention'    => $convention,
            'application'   => $application,
            'rate'          => $rate,
            'bill'          => $bill,
            'payslip'       => $payslip,
            'invoice'       => $invoice,
        ];
    }
}
