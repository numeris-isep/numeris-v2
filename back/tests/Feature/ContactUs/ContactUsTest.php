<?php

namespace Tests\Feature\ContactUs;

use App\Mail\ContactUsMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactUsTest extends TestCase
{
    public function testContactUs()
    {
        $data = [
            'first_name'    => 'John',
            'last_name'     => 'Doe',
            'email'         => $email = 'john.doe@unknown.io',
            'subject'       => 'Stay in touch',
            'content'       => 'Hello, I have basically no idea why I want to reach you but I do. Regards, Johnny Doe.'
        ];

        $this->json('POST', route('contact-us'), $data)
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        Mail::assertSent(ContactUsMail::class);
    }

    public function testContactUsWithoutData()
    {
        $this->json('POST', route('contact-us'), [])
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['first_name', 'last_name', 'email', 'subject', 'content']);

        Mail::assertNothingSent();
    }
}