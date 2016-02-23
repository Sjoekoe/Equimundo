@extends('layout.app')

@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-2">
                @if (count($horses))
                    <div class="panel">
                        <div class="panel-body">
                            {{ Form::open(['route' => 'statuses.store', 'method' => 'POST', 'class' => 'status_form', 'files' => 'true']) }}
                                <div class="col-md-10">
                                    <div class="row">
                                        {{ Form::select('horse', $horses, null, ['class' => 'form-control selectPicker', 'id' => 'js-status-select']) }}
                                    </div>
                                    <div class="row mar-top">
                                        {{ Form::textarea('body', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => trans('forms.placeholders.what_you_been_doing')]) }}
                                    </div>
                                    <div class="row mar-top">
                                        <div class="col-sm-6 pad-no">
                                            <div class="image-upload">
                                                <label for="picture">
                                                    <i class="btn btn-trans btn-icon fa fa-camera add-tooltip"></i>
                                                </label>

                                                {{ Form::file('picture', ['class' => 'pull-left', 'id' => 'picture']) }}

                                                {{--<label for="movie">
                                                    <i class="btn btn-trans btn-icon fa fa-video-camera"></i>
                                                </label>

                                                {{ Form::file('movie', ['class' => 'pull-left', 'id' => 'movie']) }}--}}
                                            </div>
                                        </div>
                                        <div class="col-sm-6 pad-no">
                                            {{ Form::submit(trans('forms.buttons.post_status'), ['class' => 'btn btn-sm btn-info pull-right']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="text-center ">
                                        <img src="{{ $initialPicture }}" alt="" id="js-status-avatar" class="img-lg img-border">
                                    </div>
                                </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                @else
                    <div class="panel">
                        <div class="panel-body text-center">
                            <p>
                                <a href="{{ route('horses.create') }}" class="text-mint">
                                    {{ trans('copy.p.please_create_horse') }}
                                </a>
                            </p>
                        </div>
                    </div>
                @endif
                @foreach($statuses as $status)
                    @include('statuses.partials.status')
                @endforeach
            </div>
        </div>
    </div>
@stop
