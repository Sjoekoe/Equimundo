@extends('layout.app')

@section('content')
    <div class="page-content" xmlns:v-bind="http://www.w3.org/1999/xhtml">
        @include('layout.partials.heading')

        <div class="col-lg-7 col-lg-offset-2">
            @if (auth()->check() && auth()->user()->isInHorseTeam($horse))
                <horsestatus></horsestatus>

                <template id="horse-status-template">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="col-md-12">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="row mar-top">
                                        <textarea name="body" id="" cols="30" rows="3" class="form-control" placeholder="{{ trans('forms.placeholders.what_you_been_doing') }}" v-model="body"></textarea>
                                        <small class="help-block text-danger text-left" v-if="errors.body"><i class="fa fa-exclamation-circle"></i> @{{ errors.body }}</small>
                                    </div>
                                    <div class="row mar-top">
                                        <div class="col-sm-6 pad-no">
                                            <div class="image-upload">
                                                <label for="picture">
                                                    <i class="btn btn-trans btn-icon fa fa-camera add-tooltip"></i>
                                                </label>
                                                <input id="picture" type="file" v-model="upload" @change="onFileChange">
                                            </div>
                                            <div v-if="image" >
                                                <img v-bind:src="image" alt="" class="img-lg img-border">
                                                <button class="btn btn-sm btn-danger" v-on:click="removeImage">X</button>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 pad-no">
                                            <template v-if="submitting">
                                                <button class="btn btn-sm btn-info pull-right" disabled><i class="fa fa-spinner fa-spin"></i></button>
                                            </template>
                                            <template v-else>
                                                <button type="submit" class="btn btn-sm btn-info pull-right" v-on:click="submit($event)">{{ trans('forms.buttons.post_status') }}</button>
                                            </template>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @include('statuses.partials._status_template')
                </template>
            @endif

            <horsefeed></horsefeed>

            <template id="horse-feed-template">
                @include('statuses.partials._status_template')
            </template>
        </div>
    </div>
    <script>
        var horse_id = {{ $horse->id() }};
    </script>
@stop
