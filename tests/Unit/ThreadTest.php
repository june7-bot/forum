<?php

namespace Tests\Unit;

use App\Reply;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->thread = factory('App\Thread')->create();
    }

    function test_thread_can_make_a_string_path()
    {
        $thread = create('App\Thread');

        $this->assertEquals('/threads/' . $thread->channel->slug . '/' . $thread->id , $thread->path() );
    }

    function test_thread_has_a_creator()
    {

        $this->assertInstanceOf('App\User' ,  $this->thread->creator);
    }

    public function test_thread_has_replies()
    {

       $this->assertInstanceOf(Collection::class , $this->thread->replies );
    }


    function test_thread_can_add_reply()
    {
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies );
    }

    function test_thread_belongs_to_channel()
    {
        $thread = create('App\Thread');

        $this->assertInstanceOf('App\Channel' , $thread->channel );
    }
}