<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Inspections\Spam;
use App\Notifications\YouWereMentioned;
use App\Reply;
use App\Rules\SpamFree;
use App\Thread;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }

    public function store($channelId, Thread $thread , CreatePostRequest $form)
    {

       return $thread->addReply([
            'body' => \request('body'),
            'user_id' => auth()->id(),
        ])->load('owner');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $this->validate(\request(), ['body' => ['required', new SpamFree],]);

        $reply->update(['body' => \request('body')]);

    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (\request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }
        return back();
    }


}
