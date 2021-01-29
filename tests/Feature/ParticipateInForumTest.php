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

        $thread = create('App\Thread');

        $reply = create('App\Reply');

        $this->post($thread->path() . '/replies', $reply->toArray());
    }

    public function test_authenticated_user_may_participate_forum_threads()
    {

        $this->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply');

        $this->post($thread->path() . '/replies' , $reply->toArray() );

        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
        $this->assertEquals(1, $thread->fresh()->replies_count);
    }


    function test_reply_requires_a_body()
    {
        $this->signIn();

        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->make(['body' => null]);

        $this->post($thread->path() . '/replies', $reply->toArray())->assertStatus(302);

    }

    function test_un_authorized_user_cannot_delete_reply()
    {
        $reply = create('App\Reply');

        $this->delete("replies/" . $reply->id)
        ->assertRedirect('/login');

        $this->signIn()
            ->delete("replies/" . $reply->id)
            ->assertStatus(403);
    }

    function test_authorized_user_can_delete_reply()
    {
        $this->signIn();
        $reply = create('App\Reply' , [ 'user_id' => auth()->id()]);

        $this->delete("replies/" . $reply->id);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

        $this->assertEquals(0 , $reply->thread->fresh()->replies_count);

    }

    function test_authorized_user_can_update_replies()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $this->patch('/replies/' . $reply->id, ['body' => 'have changed']);

        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => 'have changed']);
    }

    function test_un_authorized_user_cannot_update_reply()
    {
        $reply = create('App\Reply');

        $this->patch("replies/" . $reply->id)
            ->assertRedirect('/login');

        $this->signIn()
            ->patch("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    function test_replies_that_contain_spam_cannot_be_created()
    {

        $this->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply', [
            'body' => 'Yahoo Customer Support'
        ]);

        $this->post($thread->path() . '/replies', $reply->toArray())->assertStatus(302);
    }

    function test_users_may_only_reply_a_maximum_of_once_per_minute()
    {

        $this->signIn();
        $thread = create('App\Thread');

        $reply = make('App\Reply', [
            'body' => 'test'
        ]);


        $this->post($thread->path() . '/replies', $reply->toArray())->assertStatus(201);


        $this->post($thread->path() . '/replies', $reply->toArray())->assertStatus(429);


    }
}
