<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfilesTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_a_profile()
    {

        $user = factory('App\User')->create();

        $this->get('/profiles/' . $user->name)
            ->assertSee($user->name);
    }

    function test_profiles_display_all_threads_created_by_user()
    {
       $this->signIn();

       $thread =  create('App\Thread', ['user_id' => auth()->id()]);

        $this->get('/profiles/' . $thread->creator->name)
            ->assertSee($thread->body)
            ->assertSee($thread->title);
    }
}
