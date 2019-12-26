<?php

namespace Tests\Feature\Application\Destroy;

use App\Mail\ApplicationRemovedMail;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Tests\TestCaseWithAuth;

class DestroyStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentDeletingHisApplication()
    {
        $application = $this->ownApplicationProvider();

        $this->assertDatabaseHas('applications', $application->toArray());

        $this->json('DELETE', route('applications.destroy', ['application_id' => $application->id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        Mail::assertSent(ApplicationRemovedMail::class);

        $this->assertDatabaseMissing('applications', $application->toArray());
    }

    /**
     * @group student
     */
    public function testStudentDeletingApplicationOfOtherUser()
    {
        $application = $this->otherUserApplicationProvider();

        $this->assertDatabaseHas('applications', $application->toArray());

        $this->json('DELETE', route('applications.destroy', ['application_id' => $application->id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        Mail::assertNothingSent();

        $this->assertDatabaseHas('applications', $application->toArray());
    }
}
