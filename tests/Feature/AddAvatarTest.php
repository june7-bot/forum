<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AddAvatarTest extends TestCase
{
   use RefreshDatabase;

    public function test_only_members_can_add_avatars()
    {
        $this->json('POST', 'api/users/1/avatar')
            ->assertStatus(401);
    }

    function test_valid_avatar_must_be_provided()
    {
        $this->signIn();

        $this->json('POST', 'api/users/' . auth()->id() . '/avatar' . [
                'avatar' => 'not-an-image'
            ])->assertStatus(422);
    }

    function test_user_may_add_avatar_to_their_profile()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        Storage::fake('public');

        $this->json('POST', 'api/users/' . auth()->id() . '/avatar' . [
                'avatar' => UploadedFile::fake()->image('avatar.jpg')
            ]);

        Storage::disk('public')->assertExists('avatars/avatar.jpg');
    }
}
