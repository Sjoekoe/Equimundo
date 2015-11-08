@extends('layout.app')

@section('content')
    @include('layout.partials.heading')
    <div class="grid-block medium-12">
        <ul>
            <li>{{ $horse->name() }}</li>
            <li>{{ trans('horses.breeds.' . $horse->breed()) }}</li>
            <li>{{ trans('horses.genders.' . $horse->gender()) }}</li>
            <li>{{ $horse->dateOfBirth() }}</li>
            <li>{{ $horse->height() }}</li>
            <li>{{ trans('horses.colors.' . $horse->color()) }}</li>
        </ul>

        @foreach ($horse->userTeams as $team)
            <?php $user = $team->user()->first() ?>
            <bold>{{ trans('horse_teams.type.' . $team->type()) }}</bold>: {{ $user->fullName() }}

            @if ($user->id !== auth()->user()->id)
                (<a href="{{ route('conversation.create', ['contact' => $user->id]) }}">{{ trans('copy.a.contact_message') }}</a>)
            @endif

        @endforeach

    </div>
@stop
