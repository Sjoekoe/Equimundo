@extends('layout.app')

@section('content')
    @if (auth()->guest())
        <div class="jumbotron">
            <div class="jumbotron-contents">
                <h1>{{ trans('copy.titles.welcome_message') }}</h1>
                <p>{{ trans('copy.p.welcome_message') }}</p>
                <p>
                    <a href="{{ route('register') }}" class="btn btn-lg btn-info">{{ trans('copy.a.sign_up') }}</a>
                </p>
            </div>
        </div>
    @else
        @include('statuses.index')
    @endif
@stop
