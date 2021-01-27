<?php

namespace Tests\Feature;

use App\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    public function test_records_activity_thread_is_Created()
    {
        $this->signIn();
        $thread = create('App\Thread');

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => 'App\Thread'
        ]);

        $activity = Activity::first();
        $this->assertEquals($activity->subject->id , $thread->id );

    }

    function test_records_activity_when_a_reply_is_created()
    {
        $this->signIn();
        create('App\Reply');

        $this->assertEquals(2, Activity::count());

    }

    function test_fetches_feed_for_user()
    {
        $this->signIn();

        create('App\Thread', ['user_id' => auth()->id()] , 2);

        auth()->user()->activity()->first()->update(['created_at' => now()->subWeek()]);

        $feed = Activity::feed(auth()->user());
        $this->assertTrue($feed->keys()->contains(
            now()->format('Y-m-d')
        ));

        $this->assertTrue($feed->keys()->contains(
            now()->subWeek()->format('Y-m-d')
        ));
    }
}
