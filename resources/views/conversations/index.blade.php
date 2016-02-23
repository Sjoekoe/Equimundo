@extends('layout.app')

@section('content')
<div id="page-title">
    <h1 class="page-header text-overflow">{{ trans('copy.titles.messages') }}</h1>
</div>
<div id="page-content">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-7">

                </div>
                <hr class="hr-sm visible-xs">
                <div class="col-sm-5 clearfix">
                    <div class="pull-right">
                        <!--Pager buttons-->
                        <div class="btn-group btn-group">
                            <button class="btn btn-mint" type="button">
                                <span class="fa fa-chevron-left"></span>
                            </button>
                            <button class="btn btn-mint" type="button">
                                <span class="fa fa-chevron-right"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="hr-sm">

            <!--Mail list group-->
            <ul class="mail-list">
                @foreach (auth()->user()->conversations() as $conversation)
                    @if (! $conversation->isDeletedForUser(auth()->user()))
                        <li class="mail-list-read">
                            <div class="mail-control">
                                <label for="{{ $conversation->id() }}" class="form-checkbox form-normal form-primary">
                                    <input type="checkbox">
                                </label>
                            </div>
                            <div class="mail-from">
                                <a href="{{ route('users.profiles.show', $conversation->contactPerson(auth()->user())->slug()) }}">
                                    {{ $conversation->contactPerson(auth()->user())->fullName() }}
                                </a>
                            </div>
                            <div class="mail-time">{{ eqm_date($conversation->updated_at) }}</div>
                            <div class="mail-subject">
                                <a href="{{ route('conversation.show', $conversation->id()) }}">{{ $conversation->subject() }}</a>
                            </div>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>

        <!--Mail footer-->
        <div class="panel-footer clearfix">
            <div class="pull-right">
                <div class="btn-group btn-group">
                    <button type="button" class="btn btn-mint">
                        <span class="fa fa-chevron-left"></span>
                    </button>
                    <button type="button" class="btn btn-mint">
                        <span class="fa fa-chevron-right"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
