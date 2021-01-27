<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store($channelId , Thread $thread)
    {
        $this->validate(\request() , [
            'body' => 'required',
        ]);

        $thread->addReply([
            'body' => \request('body'),
            'user_id' => auth()->user()->id
        ]);

        return back()->with('flash', 'your reply has been left');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->update([
            'body' => \request('body'),
        ]);
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if( \request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }
        return back();
    }
}
