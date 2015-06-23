@extends('layout.app')

@section('content')
    @include('layout.partials.heading')
            @foreach ($horse->followers as $follower)
                {{ $follower->username }}
            @endforeach
@stop