@extends('layout.app')

@section('content')
    @include('layout.partials.heading')
    @foreach ($horse->followers() as $follower)
        <a href="{{ route('users.profiles.show', $follower->id()) }}">{{ $follower->fullName() }}</a>
    @endforeach
@stop
