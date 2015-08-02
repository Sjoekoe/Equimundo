@extends('layout.app')

@section('content')
    <div class="row">
        <h3>{{ trans('copy.titles.results') }}</h3>
        <h5>{{ trans('copy.titles.horses') }}</h5>

        @if (count($horses))
            @foreach ($horses as $horse)
                <p><a href="{{ route('horses.show', $horse->slug) }}">{{ $horse->name }}</a></p>
            @endforeach
        @else
            <p>{{ trans('copy.p.no_horses_found') }}</p>
        @endif

        <hr/>

        <h5>{{ trans('copy.titles.users') }}</h5>

        @if (count($profiles))
            @foreach ($profiles as $profile)
                <p><a href="{{ route('users.profiles.show', $profile->id) }}">{{ $profile->fullName() }}</a></p>
            @endforeach
        @else
            <p>{{ trans('copy.p.no_users_found') }}</p>
        @endif

    </div>
@stop
