@extends('layout.app')

@section('content')
    {{ Form::open(['route' => ['comment.update', $comment->id()], 'method' => 'PUT']) }}
    {{ Form::textarea('body', $comment->body()) }}
    {{ Form::submit(trans('forms.buttons.save'), ['class' => 'btn']) }}
    {{ Form::close() }}
@stop
