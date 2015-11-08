@extends('layout.app')

@section('content')
    @include('layout.partials.heading')
    <div class="grid-block medium-12">
        <ul>
            <li>{{ $horse->name() }}</li>
            <li>{{ array_flatten(trans('horses.breeds'))[$horse->breed() - 1] }}</li>
            <li>{{ trans('horses.genders')[$horse->gender()] }}</li>
            <li>{{ $horse->dateOfBirth() }}</li>
            <li>{{ $horse->height() }}</li>
            <li>{{ trans('horses.colors')[$horse->color()] }}</li>
        </ul>

        @foreach ($horse->userTeams as $team)
            <?php $user = $team->user()->first() ?>
            <bold>{{ trans('horse_teams.type.' . $team->type()) }}</bold>: {{ $user->fullName() }}
            (<a href="{{ route('conversation.create', ['contact' => $user->id]) }}">{{ trans('copy.a.contact_message') }}</a>)
        @endforeach

    </div>
@stop
