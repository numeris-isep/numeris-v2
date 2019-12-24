<?php

namespace Tests\Feature\Payslip\Update;

use App\Models\Payslip;
use App\Models\Role;
use App\Models\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\TestCaseWithAuth;

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
                'signed',
                'paid',
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

        $response1 = $this->json('PUT', route('payslips.update'), ['month' => $month])
            ->assertStatus(JsonResponse::HTTP_OK);

        $response2 = $this->json('PUT', route('payslips.update'), ['month' => $month])
            ->assertStatus(JsonResponse::HTTP_OK);

        $this->assertSame(json_decode($response1->getContent(), true), json_decode($response2->getContent(), true));
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
    public function testDeveloperUpdatingPayslipsCheckUserSubscriptionFirstMonth()
    {
        $month = '2000-01-01 00:00:00';
        $test_data = $this->clientAndProjectAndMissionAndConventionWithBillsProvider();
        $user = $test_data['user'];

        $this->assertNull(User::findByEmail($user->email)->subscription_dates);

        $res = $this->json('PUT', route('payslips.update'), ['month' => $month])
            ->assertStatus(JsonResponse::HTTP_OK);

        $subscription_fee = json_decode($res->getContent(), true)[0]['subscriptionFee'];

        $user = User::findByEmail($user->email);
        $this->assertEquals($subscription_fee, User::SUBSCRIPTION_0);
        $this->assertEquals($user->subscription_dates, [$month]);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingPayslipsCheckUserSubscriptionSecondMonth()
    {
        $first_month = '2000-01-01 00:00:00';
        $second_month = '2000-02-01 00:00:00';
        $test_data = $this->clientAndProjectAndMissionAndConventionWithBillsProvider(null, $second_month);
        $user = $test_data['user'];

        $user->update(['subscription_dates' => [$first_month]]);

        $this->assertEquals(User::findByEmail($user->email)->subscription_dates, [$first_month]);

        $res = $this->json('PUT', route('payslips.update'), ['month' => $second_month])
            ->assertStatus(JsonResponse::HTTP_OK);

        $subscription_fee = json_decode($res->getContent(), true)[0]['subscriptionFee'];

        $user = User::findByEmail($user->email);
        $this->assertEquals($subscription_fee, User::SUBSCRIPTION_1);
        $this->assertEquals($user->subscription_dates, [$first_month, $second_month]);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingPayslipsCheckUserSubscriptionThirdMonth()
    {
        $first_month = '2000-01-01 00:00:00';
        $second_month = '2000-02-01 00:00:00';
        $third_month = '2000-03-01 00:00:00';
        $test_data = $this->clientAndProjectAndMissionAndConventionWithBillsProvider(null, $third_month);
        $user = $test_data['user'];

        $user->update(['subscription_dates' => [$first_month, $second_month]]);

        $this->assertEquals(User::findByEmail($user->email)->subscription_dates, [$first_month, $second_month]);

        $res = $this->json('PUT', route('payslips.update'), ['month' => $third_month])
            ->assertStatus(JsonResponse::HTTP_OK);

        $subscription_fee = json_decode($res->getContent(), true)[0]['subscriptionFee'];

        $user = User::findByEmail($user->email);
        $this->assertEquals($subscription_fee, User::SUBSCRIPTION_2);
        $this->assertEquals($user->subscription_dates, [$first_month, $second_month, $third_month]);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingPayslipsCheckUserSubscriptionFourthMonth()
    {
        $first_month = '2000-01-01 00:00:00';
        $second_month = '2000-02-01 00:00:00';
        $third_month = '2000-03-01 00:00:00';
        $fourth_month = '2000-04-01 00:00:00';
        $test_data = $this->clientAndProjectAndMissionAndConventionWithBillsProvider(null, $fourth_month);
        $user = $test_data['user'];

        $user->update(['subscription_dates' => [$first_month, $second_month, $third_month]]);

        $this->assertEquals(User::findByEmail($user->email)->subscription_dates, [$first_month, $second_month, $third_month]);

        $res = $this->json('PUT', route('payslips.update'), ['month' => $fourth_month])
            ->assertStatus(JsonResponse::HTTP_OK);

        $subscription_fee = json_decode($res->getContent(), true)[0]['subscriptionFee'];

        $user = User::findByEmail($user->email);
        $this->assertEquals($subscription_fee, 0);
        $this->assertEquals($user->subscription_dates, [$first_month, $second_month, $third_month]);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingPayslipsCheckUserSubscriptionPreviousMonth()
    {
        $first_month = '2000-02-01 00:00:00';
        $second_month = '2000-01-01 00:00:00';
        $test_data = $this->clientAndProjectAndMissionAndConventionWithBillsProvider(null, $second_month);
        $user = $test_data['user'];

        $user->update(['subscription_dates' => [$first_month]]);

        $this->assertEquals(User::findByEmail($user->email)->subscription_dates, [$first_month]);

        $res = $this->json('PUT', route('payslips.update'), ['month' => $second_month])
            ->assertStatus(JsonResponse::HTTP_OK);

        $subscription_fee = json_decode($res->getContent(), true)[0]['subscriptionFee'];

        $user = User::findByEmail($user->email);
        $this->assertEquals($subscription_fee, 0);
        $this->assertEquals($user->subscription_dates, [$first_month]);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingPayslipsCheckUserSubscriptionSameFirstMonth()
    {
        $month = '2000-01-01 00:00:00';
        $test_data = $this->clientAndProjectAndMissionAndConventionWithBillsProvider();
        $user = $test_data['user'];

        $user->update(['subscription_dates' => [$month]]);

        $this->assertEquals(User::findByEmail($user->email)->subscription_dates, [$month]);

        $res = $this->json('PUT', route('payslips.update'), ['month' => $month])
            ->assertStatus(JsonResponse::HTTP_OK);

        $subscription_fee = json_decode($res->getContent(), true)[0]['subscriptionFee'];

        $user = User::findByEmail($user->email);
        $this->assertEquals($subscription_fee, User::SUBSCRIPTION_0);
        $this->assertEquals($user->subscription_dates, [$month]);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingPayslipsCheckUserSubscriptionSameSecondMonth()
    {
        $first_month = '2000-01-01 00:00:00';
        $second_month = '2000-02-01 00:00:00';
        $test_data = $this->clientAndProjectAndMissionAndConventionWithBillsProvider(null, $second_month);
        $user = $test_data['user'];

        $user->update(['subscription_dates' => [$first_month, $second_month]]);

        $this->assertEquals(User::findByEmail($user->email)->subscription_dates, [$first_month, $second_month]);

        $res = $this->json('PUT', route('payslips.update'), ['month' => $second_month])
            ->assertStatus(JsonResponse::HTTP_OK);

        $subscription_fee = json_decode($res->getContent(), true)[0]['subscriptionFee'];

        $user = User::findByEmail($user->email);
        $this->assertEquals($subscription_fee, User::SUBSCRIPTION_1);
        $this->assertEquals($user->subscription_dates, [$first_month, $second_month]);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingPayslipsCheckUserSubscriptionSameThirdMonth()
    {
        $first_month = '2000-01-01 00:00:00';
        $second_month = '2000-02-01 00:00:00';
        $third_month = '2000-03-01 00:00:00';
        $test_data = $this->clientAndProjectAndMissionAndConventionWithBillsProvider(null, $third_month);
        $user = $test_data['user'];

        $user->update(['subscription_dates' => [$first_month, $second_month, $third_month]]);

        $this->assertEquals(User::findByEmail($user->email)->subscription_dates, [$first_month, $second_month, $third_month]);

        $res = $this->json('PUT', route('payslips.update'), ['month' => $third_month])
            ->assertStatus(JsonResponse::HTTP_OK);

        $subscription_fee = json_decode($res->getContent(), true)[0]['subscriptionFee'];

        $user = User::findByEmail($user->email);
        $this->assertEquals($subscription_fee, User::SUBSCRIPTION_2);
        $this->assertEquals($user->subscription_dates, [$first_month, $second_month, $third_month]);
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
        $this->assertEquals(User::SUBSCRIPTION_0, $content['subscriptionFee']);
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
        $this->assertEquals(User::SUBSCRIPTION_0, $content['subscriptionFee']);
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
