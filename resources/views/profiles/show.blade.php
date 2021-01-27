@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="mt-5 mb-5">
                    <h1>
                        {{ $profileUser->name }}
                    </h1>

                </div>

                @forelse($activities as $date => $activity)
                    <h3 class="page-header">{{ $date }}</h3>
                    @foreach($activity as $record)
                        @if (view()->exists("profiles.activities.{$record->type}"))
                            @include("profiles.activities.{$record->type}" , ['activity' => $record])
                        @endif
                    @endforeach
                @empty
                    <p>no Activity for User</p>
                @endforelse

            </div>
        </div>
    </div>
@endsection
