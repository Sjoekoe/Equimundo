@extends('layout.app')

@section('content')
    @include('users.partials.user_sidebar_left')
    <div class="col-md-6 col-md-offset-1">
        <div class="row">
            <div class="pull-left">
                <h1>{{ $horse->name }}</h1>
            </div>

            <div class="pull-right">
                @if ($horse->owner()->first()->id !== Auth::user()->id)
                    @include('horses.partials.follow-form')
                @endif
            </div>
        </div>

        @if (! count($horse->statuses))
            <p>There are no statuses yet</p>
        @else
            @foreach($horse->statuses as $status)
                @include('statuses.partials.status')
            @endforeach
        @endif
    </div>
@stop