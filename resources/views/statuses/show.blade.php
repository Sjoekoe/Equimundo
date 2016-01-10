@extends('layout.app')

@section('content')
    <div class="row">
        {{ $status->body }}
    </div>

    <div class="comments">
        @foreach ($status->comments() as $comment)
            <div class="row">
                @include('statuses.partials.comment')
            </div>
        @endforeach
    </div>

    @if (Auth::check())
        <div class="row comment">
            {{ Form::open(['route' => ['comment.store', $status->id()], 'class' => 'comments__create-form col s12']) }}
            <div class="row">
                <div class="input-field col s12">
                    {{ Form::textarea('body', null, ['class' => 'form-control', 'rows' => 1, 'placeholder' => trans('forms.placeholders.write_a_comment')]) }}
                </div>
            </div>
            {{ Form::close() }}
        </div>
    @endif
@stop
