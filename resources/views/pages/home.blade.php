@extends('layout.app')

@section('content')
    @if (Auth::guest())
    <div class="jumbotron">
        <h1>{{ trans('copy.titles.welcome_message') }}</h1>
        <p>{{ trans('copy.p.welcome_message') }}</p>
        <p>
            <a href="{{ route('register') }}" class="btn btn-lg btn-default">{{ trans('copy.a.sign_up') }}</a>
        </p>
    </div>
    @else
        @include('statuses.index')
    @endif

@stop
