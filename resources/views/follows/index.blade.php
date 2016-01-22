@extends('layout.app')

@section('content')
    <div class="page-content">
        @include('layout.partials.heading')
        <div class="col-lg-7 col-lg-offset-2">
            @foreach ($horse->followers() as $follower)
                <div class="col-sm-4">
                    <div class="panel text-center">
                        <div class="panel-body {{ $follower->gender() == 'M' ? 'bg-primary' : 'bg-pink' }}">
                            <h4 class="mar-no">{{ $follower->fullName() }}</h4>
                            <p>{{ trans('countries.' . $follower->country()) }}</p>
                        </div>
                        <div class="pad-all">
                            <p class="text-muted">
                                {{ $follower->about() }}
                            </p>
                            <div class="pad-ver">
                                <a href="{{ route('users.profiles.show', $follower->id()) }}" class="btn btn-primary">Show profile</a>
                                <a href="{{ route('conversation.create', ['contact' => $follower->id()]) }}" class="btn btn-mint">
                                    {{ trans('copy.a.contact_message') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@stop
