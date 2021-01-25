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
}
