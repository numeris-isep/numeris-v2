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

class UpdateDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperUpdatingProjectInvoice()
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

    /**
     * @group developer
     */
    public function testDeveloperUpdatingProjectWithNoBillsInvoice()
    {
        $project = $this->projectProvider();

        $this->json('PUT', route('projects.invoices.update', ['project' => $project->id]), [])
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingProjectInvoiceWithNoProject()
    {
        $this->json('PUT', route('projects.invoices.update', ['project' => 0]), [])
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson(['errors' => [trans('api.404')]]);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingProjectInvoiceTwice()
    {
        $project = $this->clientAndProjectAndMissionAndConventionWithBillsProvider()['project'];

        $this->json('PUT', route('projects.invoices.update', ['project' => $project->id]), [])
            ->assertStatus(JsonResponse::HTTP_OK);

        $this->assertEquals(1, Invoice::all()->count());

        $this->json('PUT', route('projects.invoices.update', ['project' => $project->id]), [])
            ->assertStatus(JsonResponse::HTTP_OK);

        $this->assertEquals(1, Invoice::all()->count());
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingProjectInvoiceCheckAmounts()
    {
        $project = $this->clientAndProjectAndMissionAndConventionWithBillsProvider()['project'];

        $response = $this->json('PUT', route('projects.invoices.update', ['project' => $project->id]), [])
            ->assertStatus(JsonResponse::HTTP_OK);
        $content = json_decode($response->getContent(), true);

        $this->assertEquals(240, $content['grossAmount']);
        $this->assertEquals($content['grossAmount'] * 0.2, $content['vatAmount']);
        $this->assertEquals($content['grossAmount'] + $content['vatAmount'], $content['finalAmount']);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingProjectInvoiceCheckJsonAttributesStructure()
    {
        $project = $this->clientAndProjectAndMissionAndConventionWithBillsProvider()['project'];

        $response = $this->json('PUT', route('projects.invoices.update', ['project' => $project->id]), [])
            ->assertStatus(JsonResponse::HTTP_OK);
        $content = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('reference', $content['details'][0]);
        $this->assertArrayHasKey('title', $content['details'][0]);
        $this->assertArrayHasKey('startAt', $content['details'][0]);
        $this->assertArrayHasKey('bills', $content['details'][0]);

        $this->assertArrayHasKey('rate', $content['details'][0]['bills'][0]);
        $this->assertArrayHasKey('amount', $content['details'][0]['bills'][0]);
        $this->assertArrayHasKey('hours', $content['details'][0]['bills'][0]);
        $this->assertArrayHasKey('total', $content['details'][0]['bills'][0]);
    }
}
