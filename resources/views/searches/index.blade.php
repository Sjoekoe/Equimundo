@extends('layout.app')
<!-- todo make partials of these cards -->
@section('content')
    <div id="page-content">
        <div class="pad-btm mar-btm text-center">
            <h2 class="text-thin mar-no">{{ $count }} results found for "<i class="text-mint">{{ $searchWord }}</i>"</h2>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-control">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#horses" data-toggle="tab" aria-expanded="true">
                                        {{ trans('copy.titles.horses') }}
                                        <i class="label label-danger">{{ count($horses) }}</i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#users" data-toggle="tab" aria-expanded="false">
                                        Users
                                        <i class="label label-danger">{{ count($profiles) }}</i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div id="horses" class="tab-pane fade active in">
                                <div class="col-sm-12">
                                    <h4 class="text-thin">{{ trans('copy.titles.horses') }}</h4>
                                </div>
                                <hr>
                                @if (count($horses))
                                    @foreach($horses->chunk(4) as $horseChunk)
                                        <div class="row">
                                            @foreach ($horseChunk as $horse)
                                                <div class="col-sm-3">
                                                    <a href="{{ route('horses.show', $horse->slug()) }}">
                                                        <div class="panel widget panel-bordered-mint">
                                                            <div class="widget-header" style="background-image: url({{ $horse->getHeaderImage() ? route('file.picture', $horse->getHeaderImage()->id()) : asset('images/header.jpg') }})">
                                                            </div>
                                                            <div class="widget-body text-center">
                                                                @if ($horse->getProfilePicture())
                                                                    <img alt="Profile Picture" class="widget-img img-circle img-border-light" src="{{ route('file.picture', $horse->getProfilePicture()->id()) }}">
                                                                @else
                                                                    <img alt="Profile Picture" class="widget-img img-circle img-border-light" src="{{ asset('images/eqm.png') }}">
                                                                @endif
                                                                <h4 class="mar-no">{{ $horse->name() }}</h4>
                                                                <p class="text-muted mar-btm">{{ trans('horses.breeds.' . $horse->breed()) }}</p>

                                                                <ul class="list-unstyled text-center pad-top mar-no clearfix">
                                                                    <li class="col-sm-4">
                                                                        <span class="text-lg">{{ count($horse->statuses()) }}</span>
                                                                        <p class="text-muted text-uppercase">
                                                                            <small>{{ trans('copy.a.statuses') }}</small>
                                                                        </p>
                                                                    </li>
                                                                    <li class="col-sm-4">
                                                                        <a href="{{ route('horses.show', $horse->slug()) }}" class="btn btn-mint">
                                                                            <i class="fa fa-eye"></i>
                                                                        </a>
                                                                    </li>
                                                                    <li class="col-sm-4">
                                                                        <span class="text-lg">{{ count($horse->followers()) }}</span>
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
                                    @endforeach
                                    <div class="text-right">

                                    </div>
                                @else
                                    <p>{{ trans('copy.p.no_horses_found') }}</p>
                                @endif
                            </div>
                            <div id="users" class="tab-pane fade">
                                <div class="col-sm-12">
                                    <h4 class="text-thin">Users</h4>
                                </div>
                                <hr>
                                @if (count($profiles))
                                    @foreach($profiles->chunk(4) as $profileChunk)
                                        <div class="row">
                                            @foreach ($profileChunk as $profile)
                                                <div class="col-sm-3">
                                                    <div class="panel text-center {{ $profile->gender() == 'M' ? 'panel-bordered-primary' : 'panel-bordered-pink' }}">
                                                        <div class="panel-body {{ $profile->gender() == 'M' ? 'bg-primary' : 'bg-pink' }}">
                                                            <h4 class="mar-no">{{ $profile->fullName() }}</h4>
                                                            @if ($profile->country())
                                                                <p>{{ trans('countries.' . $profile->country()) }}</p>
                                                            @endif
                                                        </div>
                                                        <div class="pad-all">
                                                            <p class="text-muted">
                                                                {{ $profile->about() }}
                                                            </p>
                                                            <div class="pad-ver">
                                                                <a href="{{ route('users.profiles.show', $profile->id()) }}" class="btn btn-primary">Show profile</a>
                                                                <a href="{{ route('conversation.create', ['contact' => $profile->id()]) }}" class="btn btn-mint">
                                                                    {{ trans('copy.a.contact_message') }}
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                @else
                                    <p>{{ trans('copy.p.no_users_found') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
