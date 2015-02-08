@extends('layout.app')

@section('content')
    @if (Auth::guest())
    <div class="jumbotron">
        <h1>Welcome to Horse Stories</h1>
        <p>Welcome to the social media platform where you can share the life of your horse</p>
        <p>
            <a href="{{ route('register') }}" class="btn btn-lg btn-default">Register</a>
        </p>
    </div>
    @else
        <p>You are logged in</p>
    @endif

@stop