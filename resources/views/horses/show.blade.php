@extends('layout.app')

@section('content')
    @include('users.partials.user_sidebar_left')
    <div class="col-md-6 col-md-offset-1">
        <h1>{{ $horse->name }}</h1>
        @if (count($horse->pictures()->get()))
            <img src="{{ asset('uploads/pictures/' . $horse->id . '/' . $horse->pictures()->first()->path) }}" alt=""/></span>
        @endif

        @include('horses.partials.follow-form')

        @if (! count($horse->statuses))
            <p>There are no statuses yet</p>
        @else
            @foreach($horse->statuses as $status)
                @include('statuses.partials.status')
            @endforeach
        @endif
    </div>
@stop