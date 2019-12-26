<?php

namespace Tests\Feature\Application\Destroy;

use App\Mail\ApplicationRemovedMail;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Tests\TestCaseWithAuth;

class DestroyDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperDeletingHisApplication()
    {
        $application = $this->ownApplicationProvider();

        $this->assertDatabaseHas('applications', $application->toArray());

        $this->json('DELETE', route('applications.destroy', ['application_id' => $application->id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        Mail::assertSent(ApplicationRemovedMail::class);

        $this->assertDatabaseMissing('applications', $application->toArray());
    }

    /**
     * @group developer
     */
    public function testDeveloperDeletingApplicationOfOtherUser()
    {
        $application = $this->otherUserApplicationProvider();

        $this->assertDatabaseHas('applications', $application->toArray());

        $this->json('DELETE', route('applications.destroy', ['application_id' => $application->id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);

        Mail::assertNothingSent();

        $this->assertDatabaseHas('applications', $application->toArray());
    }
}
