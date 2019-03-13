<?php

namespace Tests\Feature\Application\Destroy;

use App\Models\Application;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperDeletingHisApplication()
    {
        $application_id = 37;
        $application = Application::find($application_id);

        $this->assertDatabaseHas('applications', $application->toArray());

        $this->json('DELETE', route('applications.destroy', ['application_id' => $application_id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('applications', $application->toArray());
    }

    /**
     * @group developer
     */
    public function testDeveloperDeletingApplicationOfOtherUser()
    {
        $application_id = 36;
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
