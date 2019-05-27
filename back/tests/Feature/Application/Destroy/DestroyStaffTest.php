<?php

namespace Tests\Feature\Application\Destroy;

use App\Models\Application;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffDeletingHisApplication()
    {
        $application_id = 211;
        $application = Application::find($application_id);

        $this->assertDatabaseHas('applications', $application->toArray());

        $this->json('DELETE', route('applications.destroy', ['application_id' => $application_id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('applications', $application->toArray());
    }

    /**
     * @group staff
     */
    public function testStaffDeletingApplicationOfOtherUser()
    {
        $application_id = 210;
        $application = Application::find($application_id);

        $this->assertDatabaseHas('applications', $application->toArray());

        $this->json('DELETE', route('applications.destroy', ['application_id' => $application_id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertDatabaseHas('applications', $application->toArray());
    }
}
