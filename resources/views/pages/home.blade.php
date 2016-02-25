@extends('layout.app')

@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-2">
                @if (count($horses))
                    <div class="panel">
                        <div class="panel-body">
                            {{ Form::open(['route' => 'statuses.store', 'method' => 'POST', 'class' => 'status_form', 'files' => 'true']) }}
                                <div class="col-md-10">
                                    <div class="row">
                                        {{ Form::select('horse', $horses, null, ['class' => 'form-control selectPicker', 'id' => 'js-status-select']) }}
                                    </div>
                                    <div class="row mar-top">
                                        {{ Form::textarea('body', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => trans('forms.placeholders.what_you_been_doing')]) }}
                                    </div>
                                    <div class="row mar-top">
                                        <div class="col-sm-6 pad-no">
                                            <div class="image-upload">
                                                <label for="picture">
                                                    <i class="btn btn-trans btn-icon fa fa-camera add-tooltip"></i>
                                                </label>

                                                {{ Form::file('picture', ['class' => 'pull-left', 'id' => 'picture']) }}


                                            </div>
                                        </div>
                                        <div class="col-sm-6 pad-no">
                                            {{ Form::submit(trans('forms.buttons.post_status'), ['class' => 'btn btn-sm btn-info pull-right']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="text-center ">
                                        <img src="{{ $initialPicture }}" alt="" id="js-status-avatar" class="img-lg img-border">
                                    </div>
                                </div>
                            {{ Form::close() }}
                        </div>
                    </div>
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
                    @foreach($statuses as $status)
                        @include('statuses.partials.status')
                    @endforeach
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
                                        <a href="{{ route('horses.show', $popularHorse->slug()) }}">
                                            <div class="panel widget panel-bordered-mint">
                                                <div class="widget-header" style="background-image: url({{ $popularHorse->getHeaderImage() ? route('file.picture', $popularHorse->getHeaderImage()->id()) : asset('images/header.jpg') }})">
                                                </div>
                                                <div class="widget-body text-center">
                                                    @if ($popularHorse->getProfilePicture())
                                                        <img alt="Profile Picture" class="widget-img img-circle img-border-light" src="{{ route('file.picture', $popularHorse->getProfilePicture()->id()) }}">
                                                    @else
                                                        <img alt="Profile Picture" class="widget-img img-circle img-border-light" src="{{ asset('images/eqm.png') }}">
                                                    @endif
                                                    <h4 class="mar-no">{{ $popularHorse->name() }}</h4>
                                                    <p class="text-muted mar-btm">{{ trans('horses.breeds.' . $popularHorse->breed()) }}</p>

                                                    <ul class="list-unstyled text-center pad-top mar-no clearfix">
                                                        <li class="col-sm-4">
                                                            <span class="text-lg">{{ count($popularHorse->statuses()) }}</span>
                                                            <p class="text-muted text-uppercase">
                                                                <small>{{ trans('copy.a.statuses') }}</small>
                                                            </p>
                                                        </li>
                                                        <li class="col-sm-4">
                                                            <a href="{{ route('horses.show', $popularHorse->slug()) }}" class="btn btn-mint">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        </li>
                                                        <li class="col-sm-4">
                                                            <span class="text-lg">{{ count($popularHorse->followers()) }}</span>
                                                            <p class="text-muted text-uppercase">
                                                                <small>{{ trans('copy.a.followers') }}</small>
                                                            </p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            <h4 class="text-thin">{{ trans('copy.titles.active_horses') }}</h4>
                            <div class="row">
                                @foreach ($activeHorses as $activeHorse)
                                    <div class="col-sm-4">
                                        <a href="{{ route('horses.show', $activeHorse->slug()) }}">
                                            <div class="panel widget panel-bordered-mint">
                                                <div class="widget-header" style="background-image: url({{ $activeHorse->getHeaderImage() ? route('file.picture', $activeHorse->getHeaderImage()->id()) : asset('images/header.jpg') }})">
                                                </div>
                                                <div class="widget-body text-center">
                                                    @if ($activeHorse->getProfilePicture())
                                                        <img alt="Profile Picture" class="widget-img img-circle img-border-light" src="{{ route('file.picture', $activeHorse->getProfilePicture()->id()) }}">
                                                    @else
                                                        <img alt="Profile Picture" class="widget-img img-circle img-border-light" src="{{ asset('images/eqm.png') }}">
                                                    @endif
                                                    <h4 class="mar-no">{{ $activeHorse->name() }}</h4>
                                                    <p class="text-muted mar-btm">{{ trans('horses.breeds.' . $activeHorse->breed()) }}</p>

                                                    <ul class="list-unstyled text-center pad-top mar-no clearfix">
                                                        <li class="col-sm-4">
                                                            <span class="text-lg">{{ count($activeHorse->statuses()) }}</span>
                                                            <p class="text-muted text-uppercase">
                                                                <small>{{ trans('copy.a.statuses') }}</small>
                                                            </p>
                                                        </li>
                                                        <li class="col-sm-4">
                                                            <a href="{{ route('horses.show', $activeHorse->slug()) }}" class="btn btn-mint">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        </li>
                                                        <li class="col-sm-4">
                                                            <span class="text-lg">{{ count($activeHorse->followers()) }}</span>
                                                            <p class="text-muted text-uppercase">
                                                                <small>{{ trans('copy.a.followers') }}</small>
                                                            </p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </a>
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
        </div>
    </div>
@stop
