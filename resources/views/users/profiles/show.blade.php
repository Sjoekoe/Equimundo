@extends('layout.app')

@section('content')
    <div class="row">
        <h3 class="pull-left">
            {{ $user->fullName() }}
            @if (auth()->user()->id() == $user->id())
                <a href="{{ route('users.profiles.edit') }}"><i class="fa fa-pencil"></i></a>
            @endif
        </h3>
    </div>


    <div class="row">
        <h5>{{ trans('copy.titles.horses') }}</h5>
        <ul>
            @foreach ($user->horses() as $horse)
                <li><a href="{{ route('horses.show', $horse->slug()) }}">{{ $horse->name() }}</a></li>
            @endforeach
        </ul>
    </div>
    <div class="row">
        <h5>{{ trans('copy.titles.following') }}</h5>
        <ul>
            @foreach ($user->follows as $follow)
                <li><a href="{{ route('horses.show', $follow->slug()) }}">{{ $follow->name() }}</a></li>
            @endforeach
        </ul>
    </div>
@stop
