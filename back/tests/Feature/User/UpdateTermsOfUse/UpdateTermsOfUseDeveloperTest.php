<?php

namespace Tests\Feature\User\UpdateTermsOfUse;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateTermsOfUseDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperUpdatingHisOwnTermsOfUse()
    {
        $user = auth()->user();
        $user->update(['tou_accepted' => false]);

        $data = [
            'tou_accepted' => true
        ];

        $this->json('PATCH', route('users.update.terms-of-use', ['user_id' => $user->id]), $data)
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
        $user = auth()->user();
        $user->update(['tou_accepted' => false]);

        $data = [
            'tou_accepted' => false
        ];

        $this->json('PATCH', route('users.update.terms-of-use', ['user_id' => $user->id]), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['tou_accepted']);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingHisOwnAlreadyAcceptedTermsOfUse()
    {
        $user = auth()->user();
        $user->update(['tou_accepted' => true]);

        $data = [
            'tou_accepted' => true
        ];

        $this->json('PATCH', route('users.update.terms-of-use', ['user_id' => $user->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);
    }
}
