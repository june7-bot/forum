<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;

    public function test_has_an_owner()
    {
        $reply = factory('App\Reply')->create();

        $this->assertInstanceOf( 'App\User', $reply->owner);
    }

    function test_knows_if_it_was_just_published()
    {
        $reply = create('App\Reply');

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());

    }

    function test_can_detect_all_mentioned_user_in_the_body()
    {
        $reply = create('App\Reply', [
            'body' => '@JaneDoe wants to talk to @JohnDoe'
        ]);

        $this->assertEquals(['JaneDoe' , 'JohnDoe'], $reply->mentionedUser());
    }

    function test_mentioned_usernames_body_within_anchor_tags()
    {
        $reply = new \App\Reply ([
            'body' => 'Hello @JaneDoe.'
        ]);

        $this->assertEquals(
            'Hello <a href="/profiles/JaneDoe">@JaneDoe</a>.',
            $reply->body
        );
    }
}
