<?php

namespace Tests\Feature\Application\Destroy;

use App\Models\Application;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     *
     * @dataProvider ownApplicationProvider
     */
    public function testAdministratorDeletingHisApplication($application)
    {
        $this->assertDatabaseHas('applications', $application->toArray());

        $this->json('DELETE', route('applications.destroy', ['application_id' => $application->id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('applications', $application->toArray());
    }

    /**
     * @group administrator
     *
     * @dataProvider otherUserApplicationProvider
     */
    public function testAdministratorDeletingApplicationOfOtherUser($application)
    {
        $this->assertDatabaseHas('applications', $application->toArray());

        $this->json('DELETE', route('applications.destroy', ['application_id' => $application->id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertDatabaseHas('applications', $application->toArray());
    }
}
