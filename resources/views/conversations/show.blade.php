@extends('layout.app', ['title' => $conversation->subject(), 'pageTitle' => true])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="scroll-content">
                        <div class="chat-activity-list">
                            @foreach($messages as $message)
                                <div class="chat-element">
                                    <div class="media-body {{ $message->user()->id() == auth()->user()->id() ? 'text-right' : '' }}">
                                        <small class="{{ $message->user()->id() == auth()->user()->id() ? 'pull-left' : 'pull-right' }}">
                                            {{ eqm_translated_date($message->createdAt())->diffForHumans() }}
                                        </small>
                                        <strong>
                                            <a href="{{ route('users.profiles.show', $message->user()->slug()) }}">
                                                {{ $message->user()->fullName() }}
                                            </a>
                                        </strong>
                                        <p class="m-b-xs">
                                            {{ nl2br($message->body()) }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="chat-form m-t-md">
                        {{ Form::open(['route' => ['message.store', $conversation->id()]]) }}
                        <div class="row">
                            <div class="col-xs-9">
                                {{ Form::text('message', null, ['placeholder' => 'Reply', 'class' => 'form-control chat-input']) }}
                            </div>
                            <div class="col-xs-3">
                                {{ Form::submit(trans('forms.buttons.reply'), ['class' => 'btn btn-info btn-block']) }}
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
    <script>
        $(document).ready(function () {
            $('.scroll-content').slimscroll({
                height: '350px',
                start: 'bottom'
            })
        });
    </script>
@stop
