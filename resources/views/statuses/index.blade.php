@extends('layout.app')

@section('content')
    <div class="row">
        <div class="col-md-9 col-md-offset-1 border">
            @if (count($horses))
                <div class="row">
                    <div class="status-form">
                        @include('layout.partials.errors')
                        <div class="row">
                            <div class="col-md-7 col-md-offset-1">
                                {{ Form::open(['route' => 'statuses.store', 'method' => 'POST', 'class' => 'status_form', 'files' => 'true']) }}
                                    <div class="row">
                                        {{ Form::select('horse', $horses, null, ['class' => 'form-control', 'id' => 'js-status-select']) }}
                                    </div>
                                    <br>
                                    <div class="row">
                                        {{ Form::textarea('status', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => trans('forms.placeholders.what_you_been_doing')]) }}
                                    </div>
                                    <br>
                                    <div class="row">
                                        {{ Form::file('picture', ['class' => 'pull-left']) }}
                                        {{ Form::submit(trans('forms.buttons.post_status'), ['class' => 'btn btn-info pull-right']) }}
                                    </div>
                                {{ Form::close() }}
                            </div>
                            <div class="col-md-4">
                                <div class="thumbnail">
                                    <img src="{{ $initialPicture }}" alt="" id="js-status-avatar">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <p>{{ trans('copy.p.please_create_horse') }}</p>
            @endif
        </div>
    </div>

    <div class="col-md-12">
        <div class="timeline">
            <dl class="pull-left">
                @foreach ($statuses as $status)
                    @include('statuses.partials.status')
                @endforeach
            </dl>
        </div>
    </div>
    <div>
        <p class="text-center">You have reached the end of your feed!</p>
    </div>
@stop
