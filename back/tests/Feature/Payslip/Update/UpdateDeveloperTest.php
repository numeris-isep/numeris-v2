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
                'user',
                'month',
                'hourAmount',
                'grossAmount',
                'netAmount',
                'finalAmount',
                'subscriptionFee',
                'deductionAmount',
                'employerDeductionAmount',
                'deductions' => [[
                    'socialContribution',
                    'base',
                    'employeeRate',
                    'employerRate',
                    'employeeAmount',
                    'employerAmount'
                ]],
                'operations' => [['id', 'reference', 'startAt']],
                'clients' => [['id', 'name']],
                'createdAt',
                'updatedAt',
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

        $subscription_fee = json_decode($res->getContent(), true)[0]['subscriptionFee'];

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

        $subscription_fee = json_decode($res->getContent(), true)[0]['subscriptionFee'];

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

        $subscription_fee = json_decode($res->getContent(), true)[0]['subscriptionFee'];

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

        $this->assertEquals(160, $content['grossAmount']);
        $this->assertEquals($content['grossAmount'] - $content['deductionAmount'], $content['netAmount']);
        $this->assertEquals($content['netAmount'] - $content['subscriptionFee'], $content['finalAmount']);
        $this->assertEquals(18, $content['subscriptionFee']);
        $this->assertEquals(33.3444, $content['deductionAmount']);
        $this->assertEquals(52.5216, $content['employerDeductionAmount']);
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

        $this->assertEquals(200, $content['grossAmount']);
        $this->assertEquals($content['grossAmount'] - $content['deductionAmount'], $content['netAmount']);
        $this->assertEquals($content['netAmount'] - $content['subscriptionFee'], $content['finalAmount']);
        $this->assertEquals(18, $content['subscriptionFee']);
        $this->assertEquals(41.680499999999995, $content['deductionAmount']);
        $this->assertEquals(65.652, $content['employerDeductionAmount']);
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

        $this->assertArrayHasKey('socialContribution', $content['deductions'][0]);
        $this->assertArrayHasKey('base', $content['deductions'][0]);
        $this->assertArrayHasKey('employeeRate', $content['deductions'][0]);
        $this->assertArrayHasKey('employerRate', $content['deductions'][0]);
        $this->assertArrayHasKey('employeeAmount', $content['deductions'][0]);
        $this->assertArrayHasKey('employerAmount', $content['deductions'][0]);

        $this->assertArrayHasKey('id', $content['operations'][0]);
        $this->assertArrayHasKey('reference', $content['operations'][0]);
        $this->assertArrayHasKey('startAt', $content['operations'][0]);

        $this->assertArrayHasKey('id', $content['clients'][0]);
        $this->assertArrayHasKey('name', $content['clients'][0]);
    }
}
