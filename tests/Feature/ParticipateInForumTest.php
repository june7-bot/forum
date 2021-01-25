<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    function test_Unauthenticated_user_may_not_add_replies()
    {
        $this->withoutExceptionHandling();

        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = factory('App\Thread')->create();
        $reply = factory('App\Reply')->create();

        $this->post($thread->path() . '/replies', $reply->toArray());
    }

    public function test_authenticated_user_may_participate_forum_threads()
    {

        $this->withoutExceptionHandling();

        $this->be(factory('App\User')->create());

        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->make();
        $this->post($thread->path() . '/replies' , $reply->toArray());

        $this->get($thread->path())
                ->assertSee($reply->body);
    }

    function test_reply_requires_a_body()
    {
        $this->be(factory('App\User')->create());

        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->make(['body' => null]);

        $this->post($thread->path() . '/replies', $reply->toArray())->assertSessionHasErrors('body');

    }
}
