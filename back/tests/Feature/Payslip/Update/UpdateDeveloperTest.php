<?php

namespace Tests\Feature\Payslip\Update;

use App\Models\Payslip;
use App\Models\Role;
use App\Models\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\TestCaseWithAuth;
use Tests\Traits\ClientProviderTrait;
use Tests\Traits\UserProviderTrait;

class UpdateDeveloperTest extends TestCaseWithAuth
{
    use ClientProviderTrait,
        UserProviderTrait;

    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperUpdatingPayslips()
    {
        $this->clientAndProjectAndMissionAndConventionWithBillsProvider();
        $month = '2000-01-01 00:00:00';

        $this->json('PUT', route('payslips.update'), ['month' => $month])
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'user_id',
                'month',
                'gross_amount',
                'net_amount',
                'final_amount',
                'subscription_fee',
                'deduction_amount',
                'employer_deduction_amount',
                'deductions',
                'operations',
                'clients',
            ]]);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingPayslipsWithNoProject()
    {
        $month = '1000-01-01 00:00:00';

        $this->json('PUT', route('payslips.update'), ['month' => $month])
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJson([]);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingPayslipsTwice()
    {
        $this->clientAndProjectAndMissionAndConventionWithBillsProvider();
        $month = '2000-01-01 00:00:00';

        $this->json('PUT', route('payslips.update'), ['month' => $month])
            ->assertStatus(JsonResponse::HTTP_OK);

        $this->assertEquals(1, Payslip::all()->count());

        $this->json('PUT', route('payslips.update'), ['month' => $month])
            ->assertStatus(JsonResponse::HTTP_OK);

        $this->assertEquals(1, Payslip::all()->count());
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingPayslipsForDifferentMonth()
    {
        $month1 = '2000-01-01 00:00:00';
        $this->clientAndProjectAndMissionAndConventionWithBillsProvider(null, $month1);

        $this->json('PUT', route('payslips.update'), ['month' => $month1])
            ->assertStatus(JsonResponse::HTTP_OK);

        $this->assertEquals(1, Payslip::all()->count());

        $month2 = '2000-02-01 00:00:00';
        $this->clientAndProjectAndMissionAndConventionWithBillsProvider(null, $month2);

        $this->json('PUT', route('payslips.update'), ['month' => $month2])
            ->assertStatus(JsonResponse::HTTP_OK);

        $this->assertEquals(2, Payslip::all()->count());
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingPayslipsCheckUserSubscription()
    {
        $test_data = $this->clientAndProjectAndMissionAndConventionWithBillsProvider();
        $user = $test_data['user'];
        $month = '2000-01-01 00:00:00';

        $this->assertNull(User::findByEmail($user->email)->subscription_paid_at);

        $res = $this->json('PUT', route('payslips.update'), ['month' => $month])
            ->assertStatus(JsonResponse::HTTP_OK);

        $subscription_fee = json_decode($res->getContent(), true)[0]['subscription_fee'];

        $user = User::findByEmail($user->email);
        $this->assertEquals($subscription_fee, 18);
        $this->assertNotNull($user->subscription_paid_at);
        $this->assertEquals($user->subscription_paid_at, $month);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingPayslipsCheckUserSubscriptionPaidAtMonth()
    {
        $test_data = $this->clientAndProjectAndMissionAndConventionWithBillsProvider();
        $user = $test_data['user'];
        $month = '2000-01-01 00:00:00';

        User::findByEmail($user->email)->update(['subscription_paid_at' => $month]);

        $res = $this->json('PUT', route('payslips.update'), ['month' => $month])
            ->assertStatus(JsonResponse::HTTP_OK);

        $subscription_fee = json_decode($res->getContent(), true)[0]['subscription_fee'];

        $user = User::findByEmail($user->email);
        $this->assertEquals($subscription_fee, 18);
        $this->assertNotNull($user->subscription_paid_at);
        $this->assertEquals($user->subscription_paid_at, $month);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingPayslipsCheckUserSubscriptionPaidAtOtherMonth()
    {
        $test_data = $this->clientAndProjectAndMissionAndConventionWithBillsProvider();
        $user = $test_data['user'];
        $month = '2000-01-01 00:00:00';
        $subscription_paid_at = '2000-02-01 00:00:00';

        $user = User::findByEmail($user->email);
        $user->update(['subscription_paid_at' => $subscription_paid_at]);
        $this->assertEquals($user->subscription_paid_at, $subscription_paid_at);

        $res = $this->json('PUT', route('payslips.update'), ['month' => $month])
            ->assertStatus(JsonResponse::HTTP_OK);

        $subscription_fee = json_decode($res->getContent(), true)[0]['subscription_fee'];

        $user = User::findByEmail($user->email);
        $this->assertEquals($subscription_fee, 0);
        $this->assertNotNull($user->subscription_paid_at);
        $this->assertEquals($user->subscription_paid_at, $subscription_paid_at);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingPayslipsCheckAmountsForStudent()
    {
        $user = $this->activeUserProvider();
        $this->clientAndProjectAndMissionAndConventionWithBillsProvider($user);
        $month = '2000-01-01 00:00:00';

        $response = $this->json('PUT', route('payslips.update'), ['month' => $month])
            ->assertStatus(JsonResponse::HTTP_OK);
        $content = json_decode($response->getContent(), true)[0];

        $this->assertEquals(160, $content['gross_amount']);
        $this->assertEquals($content['gross_amount'] - $content['deduction_amount'], $content['net_amount']);
        $this->assertEquals($content['net_amount'] - $content['subscription_fee'], $content['final_amount']);
        $this->assertEquals(18, $content['subscription_fee']);
        $this->assertEquals(33.3444, $content['deduction_amount']);
        $this->assertEquals(52.5216, $content['employer_deduction_amount']);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingPayslipsCheckAmountsForStaff()
    {
        $user = $this->activeStaffProvider();
        $this->clientAndProjectAndMissionAndConventionWithBillsProvider($user);
        $month = '2000-01-01 00:00:00';

        $response = $this->json('PUT', route('payslips.update'), ['month' => $month])
            ->assertStatus(JsonResponse::HTTP_OK);
        $content = json_decode($response->getContent(), true)[0];

        $this->assertEquals(200, $content['gross_amount']);
        $this->assertEquals($content['gross_amount'] - $content['deduction_amount'], $content['net_amount']);
        $this->assertEquals($content['net_amount'] - $content['subscription_fee'], $content['final_amount']);
        $this->assertEquals(18, $content['subscription_fee']);
        $this->assertEquals(41.680499999999995, $content['deduction_amount']);
        $this->assertEquals(65.652, $content['employer_deduction_amount']);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingPayslipsCheckJsonAttributesStructure()
    {
        $user = $this->activeStaffProvider();
        $this->clientAndProjectAndMissionAndConventionWithBillsProvider($user);
        $month = '2000-01-01 00:00:00';

        $response = $this->json('PUT', route('payslips.update'), ['month' => $month])
            ->assertStatus(JsonResponse::HTTP_OK);
        $content = json_decode($response->getContent(), true)[0];

        $deductions = json_decode($content['deductions'], true);
        $operations = json_decode($content['operations'], true);

        $this->assertArrayHasKey('social_contribution', $deductions[0]);
        $this->assertArrayHasKey('base', $deductions[0]);
        $this->assertArrayHasKey('employee_amount', $deductions[0]);
        $this->assertArrayHasKey('employer_amount', $deductions[0]);

        $this->assertArrayHasKey('reference', $operations[0]);
        $this->assertArrayHasKey('start_at', $operations[0]);
    }
}
