@extends('layout.app')

@section('content')
    <div class="row">
        <h3>Results</h3>
        <h5>Horses</h5>

        @if (count($horses))
            @foreach ($horses as $horse)
                <p><a href="{{ route('horses.show', $horse->slug) }}">{{ $horse->name }}</a></p>
            @endforeach
        @else
            <p>No horses found</p>
        @endif

        <hr/>

        <h5>Users</h5>

        @if (count($profiles))
            @foreach ($profiles as $profile)
                <p><a href="{{ route('users.profiles.show', $profile->id) }}">{{ $profile->username }}</a></p>
            @endforeach
        @else
            <p>No users found</p>
        @endif

    </div>
@stop
