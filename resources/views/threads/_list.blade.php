<div class="card">
    <div class="card-header">Forum Threads</div>
    <div class="card-body">
        @forelse($threads as $thread)
            <article>
                <div class="level">
                    <div style="display: flex; flex-direction: column">
                        <h4>
                            <a href="{{ $thread->path() }}">
                                @if( auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                                    <strong>
                                        {{ $thread->title }}
                                    </strong>
                                @else
                                    {{ $thread->title }}
                                @endif
                            </a>
                        </h4>
                        <h5> Posted by: <a href=" {{ route('profile', $thread->creator) }}">
                                {{ $thread->creator->name }} </a></h5>
                    </div>
                    <a href="{{ $thread->path() }}">
                        <strong> {{$thread->replies_count}} {{Str::plural('reply' , $thread->replies_count)}} </strong>
                    </a>
                </div>
                <div class="body">{{ $thread->body }}</div>
            </article>
            <hr/>
        @empty
            <p>There are no relevant results at this time.</p>
        @endforelse
    </div>
</div>
