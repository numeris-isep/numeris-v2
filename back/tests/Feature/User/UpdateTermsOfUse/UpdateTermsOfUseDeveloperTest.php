<?php

namespace Tests\Feature\User\UpdateTermsOfUse;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Tests\TestCaseWithAuth;

class UpdateTermsOfUseDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperUpdatingHisOwnTermsOfUse()
    {
        $user_id = 2; // Own terms-of-use

        User::find($user_id)->update(['tou_accepted' => false]);

        $data = [
            'tou_accepted' => true
        ];

        $this->json('PATCH', route('users.update.terms-of-use', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'phone',
                'nationality',
                'birthDate',
                'birthCity',
                'socialInsuranceNumber',
                'iban',
                'bic',
                'createdAt',
                'updatedAt',
            ]);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingHisOwnTermsOfUseWithFalseValue()
    {
        $user_id = 2; // Own terms-of-use

        User::find($user_id)->update(['tou_accepted' => false]);

        $data = [
            'tou_accepted' => false
        ];

        $this->json('PATCH', route('users.update.terms-of-use', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['tou_accepted']);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingHisOwnAlreadyAcceptedTermsOfUse()
    {
        $user_id = 2; // Own terms-of-use

        User::find($user_id)->update(['tou_accepted' => true]);

        $data = [
            'tou_accepted' => true
        ];

        $this->json('PATCH', route('users.update.terms-of-use', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['error' => trans('api.403')]);
    }
}
