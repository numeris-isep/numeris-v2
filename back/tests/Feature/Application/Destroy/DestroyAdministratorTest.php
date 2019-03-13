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
     */
    public function testAdministratorDeletingHisApplication()
    {
        $application_id = 109;
        $application = Application::find($application_id);

        $this->assertDatabaseHas('applications', $application->toArray());

        $this->json('DELETE', route('applications.destroy', ['application_id' => $application_id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('applications', $application->toArray());
    }

    /**
     * @group administrator
     */
    public function testAdministratorDeletingApplicationOfOtherUser()
    {
        $application_id = 108;
        $application = Application::find($application_id);

        $this->assertDatabaseHas('applications', $application->toArray());

        $this->json('DELETE', route('applications.destroy', ['application_id' => $application_id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403')
            ]);

        $this->assertDatabaseHas('applications', $application->toArray());
    }
}
