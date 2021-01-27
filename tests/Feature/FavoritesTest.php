<?php

namespace Tests\Feature;

use App\Favorite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    use RefreshDatabase;

    function test_guest_can_not_favorite_anything()
    {
        $this->post('replies/1/favorites')
        ->assertRedirect('/login');
    }

    public function test_authenticated_user_can_favorite_any_reply()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $reply = create('App\Reply');

        $this->post('replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);
    }

    public function test_authenticated_user_can_unfavorite_a_reply()
    {

        $this->signIn();

        $reply = create('App\Reply');

        $reply->favorite();

        $this->assertCount(1, $reply->favorites);
        $reply->unfavorite();

        $this->assertCount(0, $reply->fresh()->favorites);
    }


    function test_authenticated_user_one_time_reply()
    {
        $this->signIn();

        $reply = create('App\Reply');

        $this->post('replies/' . $reply->id . '/favorites');
        $this->post('replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);
    }
}
