@extends('layout.app')

@section('content')
    @include('layout.partials.heading')
    <div class="grid-block medium-12">
        <ul>
            <li>{{ $horse->name }}</li>
            <li>{{ array_flatten(trans('horses.breeds'))[$horse->breed -1] }}</li>
            <li>{{ trans('horses.genders')[$horse->gender] }}</li>
            <li>{{ $horse->date_of_birth }}</li>
            <li>{{ $horse->height }}</li>
            <li>{{ trans('horses.colors')[$horse->color] }}</li>
        </ul>
        <a href="{{ route('conversation.create', ['contact' => $horse->owner->id]) }}">{{ trans('copy.a.contact_owner') }} {{ $horse->owner->username }}</a>
    </div>
@stop
