@extends('layouts.app')

@section('content')
    <thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
        <div class="container" style="margin-left: 400px">
            <div class="row mb-3">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="level">
                                <h3>
                                    <a href="{{ route('profile', $thread->creator)  }}"> {{ $thread->creator->name }}</a>
                                    posted: {{$thread->title }}
                                </h3>
                                @can('update',$thread)
                                    <form action="{{ $thread->path() }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-link">Delete Thread</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            {{$thread->body}}
                        </div>
                    </div>

                    <replies @added="repliesCount++" @removed="repliesCount--"></replies>


                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            for Head
                        </div>
                        <div class="card-body">
                            <p> This thread was published {{ $thread->created_at->diffForHumans() }} by
                                <a href="#"> {{ $thread->creator->name }}</a>, and currently has
                                <span
                                    v-text="repliesCount"></span> {{ Str::plural('comment',  $thread->replies_count ) }}
                                .
                            </p>

                            <p>
                                <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}"></subscribe-button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </thread-view>
@endsection
