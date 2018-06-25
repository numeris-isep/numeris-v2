<?php

namespace Tests\Feature\User\Show;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffAccessingUserShow()
    {
        $user_id = 1;

        $this->json('GET', route('users.show', ['user' => $user_id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'id',
                'notification_id',
                'address_id',
                'activated',
                'tou_accepted',
                'membership_fee_paid',
                'email',
                'username',
                'first_name',
                'last_name',
                'student_number',
                'promotion',
                'phone',
                'nationality',
                'birth_date',
                'birth_city',
                'social_insurance_number',
                'iban',
                'bic',
                'created_at',
                'updated_at'
            ]);
    }
}
