@extends('layout.app')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            @if (count($horses))
                <statuscreator></statuscreator>

                <template id="status-creator">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="col-md-10">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <select class="form-control selectPicker" v-model="selected" v-bind:value="selectedId" v-on:change="changeImage">
                                            <option v-for="option in options" v-bind:value="option.id">
                                                @{{ option.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <br>
                                    <div class="row mar-top">
                                        <textarea name="body" id="" cols="30" rows="3" class="form-control" placeholder="{{ trans('forms.placeholders.what_you_been_doing') }}" v-model="body"></textarea>
                                        <small class="help-block text-danger text-left" v-if="errors.body"><i class="fa fa-exclamation-circle"></i> @{{ errors.body }}</small>
                                    </div>
                                    <br>
                                    <div class="row mar-top">
                                        <div class="col-sm-6 pad-no">
                                            <div class="image-upload">
                                                <label for="picture">
                                                    <i class="btn btn-trans btn-icon fa fa-camera add-tooltip"></i>
                                                </label>
                                                <input id="picture" type="file" v-model="upload" @change="onFileChange">
                                            </div>
                                            <div v-if="image" >
                                                <img v-bind:src="image" alt="" class="profile-image">
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
                            <div class="col-md-2">
                                <div class="profile-image">
                                    <img v-bind:src="currentPicture">
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('statuses.partials._status_template')
                </template>
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
            @if (count($statuses))
                <userfeed></userfeed>

                <template id="user-feed-template">
                    @include('statuses.partials._status_template')
                </template>
            @else
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            {{ trans('copy.titles.lets_get_started') }}
                        </h3>
                    </div>
                    <div class="panel-body">
                        <h4 class="text-thin">{{ trans('copy.titles.popular_horses') }}</h4>
                        <div class="row">
                            @foreach ($popularHorses as $popularHorse)
                                <div class="col-sm-4">
                                    @include('horses._partials._horse_info', ['horse' => $popularHorse])
                                </div>
                            @endforeach
                        </div>
                        <h4 class="text-thin">{{ trans('copy.titles.active_horses') }}</h4>
                        <div class="row">
                            @foreach ($activeHorses as $activeHorse)
                                <div class="col-sm-4">
                                    @include('horses._partials._horse_info', ['horse' => $activeHorse])
                                </div>
                            @endforeach
                        </div>
                        <h4 class="text-thin">{{ trans('copy.titles.latest_users') }}</h4>
                        <div class="row">
                            @foreach ($latestUsers as $latestUser)
                                <div class="col-sm-4">
                                    <div class="panel text-center {{ $latestUser->gender() == 'M' ? 'panel-bordered-primary' : 'panel-bordered-pink' }}">
                                        <div class="panel-body {{ $latestUser->gender() == 'M' ? 'bg-primary' : 'bg-pink' }}">
                                            <h4 class="mar-no">{{ $latestUser->fullName() }}</h4>
                                            @if ($latestUser->country())
                                                <p>{{ trans('countries.' . $latestUser->country()) }}</p>
                                            @endif
                                        </div>
                                        <div class="pad-all">
                                            <p class="text-muted">
                                                {{ $latestUser->about() }}
                                            </p>
                                            <div class="pad-ver">
                                                <a href="{{ route('users.profiles.show', $latestUser->slug()) }}" class="btn btn-primary">Show profile</a>
                                                <a href="{{ route('conversation.create', ['contact' => $latestUser->id()]) }}" class="btn btn-mint">
                                                    {{ trans('copy.a.contact_message') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            @endif
        </div>
        <div class="col-md-3">
            @include('advertisements.rectangle')
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        {{ trans('copy.titles.latest_horses') }}
                    </h3>
                </div>
                <div class="panel-body">
                    @foreach ($latestHorses as $latestHorse)
                        <a href="{{ route('horses.show', $latestHorse->slug()) }}" class="text-mint">{{ $latestHorse->name() }}</a> <br>
                    @endforeach
                </div>
            </div>

            <div class="alert alert-info fade in">
                <button class="close" data-dismiss="alert">
                    <span>×</span>
                </button>
                <h4 class="alert-title">
                    {{ trans('copy.titles.invite_your_friends') }}
                </h4>
                <br>
                <p class="alert-message">
                    {{ trans('copy.p.invite_your_friends') }}
                </p>
                <br>
                <div class="mar-top">
                    <a href="{{ route('invite_friends') }}" class="btn btn-info">{{ trans('copy.a.invite_now') }}</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        var user_id = {{ auth()->user()->id() }}
    </script>
@stop
