@extends('layout.app')

@section('content')
    <h3>{{ $user->username }}</h3>
    <div class="row">
        <h5>Horses</h5>
        <ul>
            @foreach ($user->horses as $horse)
                <li><a href="{{ route('horses.show', $horse->id) }}">{{ $horse->name }}</a></li>
            @endforeach
        </ul>
    </div>
    <div class="row">
        <h5>Following</h5>
        <ul>
            @foreach ($user->follows as $follow)
                <li><a href="{{ route('horses.show', $follow->id) }}">{{ $follow->name }}</a></li>
            @endforeach
        </ul>
    </div>
@stop
