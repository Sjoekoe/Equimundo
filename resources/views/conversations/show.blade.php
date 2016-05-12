@extends('layout.app', ['title' => $conversation->subject(), 'pageTitle' => true])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="ibox float-e-margins">
                <showconversation></showconversation>

                <template id="show-conversation">
                    <div class="ibox-content">
                        <div class="scroll-content" id="scrollable" style="height: 500px; overflow: scroll">
                            <template v-if="final_page_not_reached">
                                <button class="btn btn-link btn-block btn-outline" @click="loadOlder" v-if="loading" disabled>
                                    <i class="fa fa-spin fa-spinner"></i> {{ trans('copy.a.loading_older_messages') }}
                                </button>
                                <button class="btn btn-info btn-block btn-outline" @click="loadOlder" v-else>
                                    {{ trans('copy.a.load_older_messages') }}
                                </button>
                                <hr>
                            </template>
                            <div class="chat-activity-list">
                                <div class="chat-element" v-for="message in olderMessages | orderBy 'created_at'">
                                    @include('conversations._partials._message')
                                </div>
                                <div class="chat-element" v-for="message in messages | orderBy 'created_at'">
                                    @include('conversations._partials._message')
                                </div>
                            </div>
                        </div>
                        <div class="chat-form m-t-md">
                            <div class="row">
                                <div class="col-xs-9">
                                    <input type="text" v-model="body" class="form-control chat-input" placeholder="{{ trans('forms.buttons.reply') }}" v-on:keyup.enter="reply">
                                    <label id="body" class="error" for="body" v-if="errors.body">@{{ errors.body }}</label>
                                </div>
                                <div class="col-xs-3">
                                    <button class="btn btn-info btn-block" v-if="replying" disabled>
                                        <i class="fa fa-spin fa-spinner"></i> Replying...
                                    </button>
                                    <button class="btn btn-info btn-block" @click="reply" v-else>{{ trans('forms.buttons.reply') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
@stop


