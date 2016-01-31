@extends('layout.app')

@section('content')
    <div id="page-title">
        <div class="col-md-8 col-md-offset-2 cl-sm-12">
            <a href="{{ route('conversation.index') }}" class="btn btn-info btn-small pull-right">Back to Inbox</a>
        </div>
    </div>
    <div id="page-content">
        <div class="col-md-8 col-md-offset-2 col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ $conversation->subject() }}</h3>
                </div>

                <div id="chat-body" class="collapse in" aria-expanded="true">
                    <div class="nano" style="height:500px">
                        <div id="chat-content" class="nano-content pad-all" tabindex="0">
                            <ul class="list-unstyled media-block">
                                @foreach ($messages as $message)
                                    @if ($message->user()->id() == auth()->user()->id())
                                    <li class="mar-btm">
                                        <div class="media-right">
                                            <p>{{ substr($message->user()->fullName(), 0, 1) }}</p>
                                        </div>
                                        <div class="media-body pad-hor speech-right">
                                            <div class="speech">
                                                <a href="{{ route('users.profiles.show', $message->user()->id()) }}" class="media-heading">{{ $message->user()->fullName() }}</a>
                                                <p>{{ nl2br($message->body()) }}</p>
                                                <p class="speech-time">
                                                    <i class="fa fa-clock-o fa-fw"></i>{{ eqm_translated_date($message->createdAt())->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                    @else
                                        <li class="mar-btm">
                                            <div class="media-left">
                                                <p>{{ substr($message->user()->fullName(), 0, 1) }}</p>
                                            </div>
                                            <div class="media-body pad-hor">
                                                <div class="speech">
                                                    <a href="{{ route('users.profiles.show', $message->user()->id()) }}" class="media-heading">{{ $message->user()->fullName() }}</a>
                                                    <p>{{ nl2br($message->body()) }}</p>
                                                    <p class="speech-time">
                                                        <i class="fa fa-clock-o fa-fw"></i>{{ eqm_translated_date($message->createdAt())->diffForHumans() }}
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="nano-pane"><div class="nano-slider" style="height: 137px; transform: translate(0px, 0px);"></div></div></div>

                    <!--Widget footer-->
                    <div class="panel-footer">
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
        var objDiv = document.getElementById("chat-content");
        objDiv.scrollTop = objDiv.scrollHeight;
    </script>
@stop
