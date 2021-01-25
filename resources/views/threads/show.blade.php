@extends('layouts.app')

@section('content')
    <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-md-offset-2">
                    <div class="card">
                        <div class="card-header">
                            <a href="#"> {{ $thread->creator->name }}</a> posted:
                            {{$thread->title }}</div>
                             <div class="card-body">
                                {{$thread->body}}
                            </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8 col-md-offset-2">
                @foreach( $thread->replies as $reply )
                    @include('threads.reply')
                @endforeach
            </div>
        </div>

        @auth
            <div class="row justify-content-center" style="padding-bottom: 30px">
                <div class="col-md-8 col-md-offset-2">
                    <form method="POST" action="{{ $thread->path() . '/replies' }}">
                        @csrf
                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control" placeholder="Have something to say?" rows="5"></textarea>
                        </div>

                        <button class="btn btn-link">Post</button>
                    </form>
                </div>
            </div>
        @endauth
        @guest
            <p class="text-center">Please <a href="{{ route('login') }}">sign in</a>  to participate in this discussion</p>
        @endguest
    </div>
@endsection
