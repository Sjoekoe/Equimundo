@extends('layout.app')

@section('content')
    <div class="grid-content">
        @if (count($horses))
            <div class="grid-block medium-12 status">
                @include('layout.partials.errors')

                {{ Form::open(['route' => 'statuses.store', 'class' => 'grid-content medium-12 status_form']) }}

                <!-- Status Form input -->
                <div class="medium-12 grid-content">
                    {{ Form::select('horse', $horses, null, ['class' => 'form-control']) }}
                </div>

                <!-- Status Form input -->
                <div class="medium-12 grid-content">
                    {{ Form::textarea('status', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => 'what have you been doing ...']) }}
                </div>

                <!-- Submit button -->
                <div class="medium-12 grid-content">
                    {{ Form::submit('Post Status', ['class' => 'button pull-right']) }}
                </div>

                {{ Form::close() }}
            </div>
        @else
            <p>Please create a horse first before you can post a status</p>
        @endif
        @foreach ($statuses as $status)
            @include('statuses.partials.status')
        @endforeach
    </div>
@stop