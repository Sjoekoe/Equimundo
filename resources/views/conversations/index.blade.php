@extends('layout.app', ['title' => trans('copy.titles.messages'), 'pageTitle' => true])

@section('content')

@include('advertisements.leaderboard')

<div id="row">
    <div class="col-md-12">
        <div class="mail-box-header">
            <h2>Inbox</h2>
        </div>
        <div class="mail-box">
            <table class="table table-hover table-mail">
                <tbody>
                    @foreach (auth()->user()->conversations() as $conversation)
                        <tr class="{{ $conversation->hasUnreadMessages(auth()->user()) ? 'unread' : '' }}">
                            <td class="check-mail">
                                {{ Form::checkbox('messages[]', $conversation->id(), false, ['id' => $conversation->id(), 'class' => 'i-checks']) }}
                            </td>
                            <td class="mail-ontact">
                                <a href="{{ route('users.profiles.show', $conversation->contactPerson(auth()->user())->slug()) }}">
                                    {{ $conversation->contactPerson(auth()->user())->fullName() }}
                                </a>
                            </td>
                            <td class="mail-subject">
                                <a href="{{ route('conversation.show', $conversation->id()) }}">{{ $conversation->subject() }}</a>
                            </td>
                            <td class="text-right mail-date">
                                {{ eqm_date($conversation->created_at) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop
