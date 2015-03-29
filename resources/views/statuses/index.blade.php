@extends('layout.app')

@section('content')
    @include('users.partials.user_sidebar_left')

    <div class="col-md-6 col-md-offset-1 status">
        <div class="row">
            @if (count($horses))
                <div class="col-md-8 status status-form">
                    @include('layout.partials.errors')

                    {{ Form::open(['route' => 'statuses.store']) }}

                    <!-- Status Form input -->
                    <div class="form-group">
                        {{ Form::select('horse', $horses, null, ['class' => 'form-control']) }}
                    </div>

                    <!-- Status Form input -->
                    <div class="form-group">
                        {{ Form::textarea('status', null, ['class' => 'form-control', 'rows' => 3]) }}
                    </div>

                    <!-- Submit button -->
                    <div class="form-group">
                        {{ Form::submit('Post Status', ['class' => 'btn btn-default form-control']) }}
                    </div>

                    {{ Form::close() }}
                </div>
                <div class="col-md-4 status">

                </div>
            @else
                <p>Please create a horse first before you can post a status</p>
            @endif
        </div>
        @foreach($statuses as $status)
            @include('statuses.partials.status')
        @endforeach
    </div>

    <div class="col-md-2">
        Other Things
    </div>
@stop