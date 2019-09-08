<?php

namespace Tests\Feature\ProjectInvoice\Update;

use App\Models\Invoice;
use App\Models\Payslip;
use App\Models\Role;
use App\Models\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\TestCaseWithAuth;
use Tests\Traits\ClientProviderTrait;
use Tests\Traits\ProjectProviderTrait;
use Tests\Traits\UserProviderTrait;

class UpdateStaffTest extends TestCaseWithAuth
{
    protected $username = Role::STAFF;

    /**
     * @group staff
     */
    public function testStaffUpdatingProjectInvoice()
    {
        $project = $this->clientAndProjectAndMissionAndConventionWithBillsProvider()['project'];

        $this->json('PUT', route('projects.invoices.update', ['project' => $project->id]), [])
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'id',
                'grossAmount',
                'vatAmount',
                'finalAmount',
                'details' => [[
                    'reference',
                    'title',
                    'startAt',
                    'bills' => [[
                        'rate',
                        'amount',
                        'hours',
                        'total',
                    ]],
                ]],
                'createdAt',
                'updatedAt',
            ]);
    }
}
