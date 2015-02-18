@extends('layout.app')

@section('content')
    @include('users.partials.user_sidebar_left')

    <div class="col-md-6 col-md-offset-1">
        <h1>Post a status</h1>

        @include('layout.partials.errors')

        {!! Form::open(['route' => 'statuses.store']) !!}

        <!-- Status Form input -->
        <div class="form-group">
            {!! Form::label('horse', 'Horse:') !!}
            {!! Form::select('horse', $horses, null, ['class' => 'form-control']) !!}
        </div>

        <!-- Status Form input -->
        <div class="form-group">
            {!! Form::label('status', 'Status:') !!}
            {!! Form::textarea('status', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Submit button -->
        <div class="form-group">
            {!! Form::submit('Post Status', ['class' => 'btn btn-default form-control']) !!}
        </div>

        {!! Form::close() !!}

        @foreach(Auth::user()->statuses as $status)
            {{ $status->body }}
        @endforeach
    </div>

    <div class="col-md-2">
        Other Things
    </div>
@stop