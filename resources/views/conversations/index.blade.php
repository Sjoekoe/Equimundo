@extends('layout.app')

@section('content')
<div id="page-title">
    <h1 class="page-header text-overflow">Messages</h1>
</div>
<div id="page-content">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-7">
                    <div class="btn-group">
                        <div id="demo-checked-all-mail" class="btn btn-default">
                            <label class="form-checkbox form-normal form-primary">
                                <input class="form-input" type="checkbox" name="mail-list">
                            </label>
                        </div>
                        <button data-toggle="dropdown" class="btn btn-default dropdown-toggle dropdown-toggle-icon"><i class="dropdown-caret fa fa-caret-down"></i></button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:void(0)" id="demo-select-all-list">All</a></li>
                            <li><a href="javascript:void(0)" id="demo-select-none-list">None</a></li>
                            <li><a href="javascript:void(0)" id="demo-select-toggle-list">Toggle</a></li>
                            <li class="divider"></li>
                            <li><a href="javascript:void(0)" id="demo-select-read-list">Read</a></li>
                            <li><a href="javascript:void(0)" id="demo-select-unread-list">Unread</a></li>
                            <li><a href="javascript:void(0)" id="demo-select-starred-list">Starred</a></li>
                        </ul>
                    </div>

                    <!--Dropdown button (More Action)-->
                    <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">
                            More <i class="dropdown-caret fa fa-caret-down"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Mark as read</a></li>
                            <li><a href="#">Mark as unread</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Star</a></li>
                            <li><a href="#">Clear Star</a></li>
                        </ul>
                    </div>
                </div>
                <hr class="hr-sm visible-xs">
                <div class="col-sm-5 clearfix">
                    <div class="pull-right">

                        <!--Pager buttons-->
                            <span class="text-muted">
                                <strong>1-50</strong>
                                of
                                <strong>{{ count(auth()->user()->conversations()) }}</strong>
                            </span>
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
                                <a href="{{ route('users.profiles.show', $conversation->contactPerson(auth()->user())->id()) }}">
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
                <span class="text-muted"><strong>1-50</strong> of <strong>{{ count(auth()->user()->conversations()) }}</strong></span>
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
