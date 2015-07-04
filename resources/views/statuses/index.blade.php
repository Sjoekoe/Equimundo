@extends('layout.app')

@section('content')
    <div class="row">
        <div class="col s12">
            @if (count($horses))
                <div class="row">
                    <div class="col s12 status-form">
                        @include('layout.partials.errors')
                        {{ Form::open(['route' => 'statuses.store', 'class' => 'col s12 status_form', 'files' => 'true']) }}

                        <!-- Status Form input -->
                        <div class="row">
                            <div class="input-field col s12">
                                {{ Form::select('horse', $horses, null, ['class' => 'horse-select']) }}
                            </div>
                        </div>

                        <!-- Status Form input -->
                        <div class="row">
                            <div class="input-field col s12">
                                {{ Form::textarea('status', null, ['class' => 'materialize-textarea', 'rows' => 3, 'placeholder' => trans('forms.placeholders.what_you_been_doing')]) }}
                            </div>
                        </div>

                        <!-- Submit button -->
                        <div class="file-field input-field">
                            <input class="file-path validate" type="text"/>
                            <div class="btn">
                                <span>{{ trans('copy.span.file') }}</span>
                                {{ Form::file('picture') }}
                            </div>
                        </div>
                        {{ Form::submit(trans('forms.buttons.post_status'), ['class' => 'btn right']) }}

                        {{ Form::close() }}
                    </div>
                </div>
            @else
                <p>{{ trans('copy.p.please_create_horse') }}</p>
            @endif
        </div>
    </div>
    @foreach ($statuses as $status)
        @include('statuses.partials.status')
    @endforeach
@stop

@section('footer')
    <script>
        $(document).ready(function() {
            $('.horse-select').material_select();
        });
    </script>
@stop
