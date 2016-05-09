
@extends('layout.app', ['title' => $user->fullName(), 'pageTitle' => true])

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="ibox float-e-margins">
                <div class="ibox-content profile-content">
                    @if ($user->facebook())
                        <a title="" href="http://www.facebook.com/{{ $user->facebook() }}" target="_blank" class="btn btn-success btn-circle add-tooltip" data-original-title="Facebook" data-container="body">
                            <i class="fa fa-facebook"></i>
                        </a>
                    @endif

                    @if ($user->twitter())
                        <a title="" href="http://www.twitter.com/{{ $user->twitter() }}" target="_blank" class="btn btn-info btn-circle add-tooltip" data-original-title="Twitter" data-container="body">
                            <i class="fa fa-twitter"></i>
                        </a>
                    @endif

                    @if ($user->website())
                        <a title="" href="{{ $user->website() }}" target="_blank" class="btn btn-danger btn-circle add-tooltip" data-original-title="Website" data-container="body">
                            <i class="fa fa-laptop"></i>
                        </a>
                    @endif

                    <hr>

                    @if ($user->country())
                        <p>
                            <i class="fa fa-home fa-fw"></i> {{ trans('countries.' . $user->country()) }}
                        </p>
                    @endif
                    <p>
                        <i class="fa fa-clock-o fa-fw"></i> {{ trans('copy.titles.member_since') }} : {{ eqm_translated_date($user->created_at)->format('F Y') }}
                    </p>

                    <hr>
                    <h5>{{ trans('copy.titles.about_me') }}</h5>
                    <p>{{ $user->about() }}</p>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <strong>{{ count($user->horses()) }}</strong> {{ trans('copy.titles.horses') }}
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5>
                                <strong>{{ count($user->follows()) }}</strong> {{ trans('copy.titles.following') }}
                            </h5>
                        </div>
                    </div>
                    <hr>
                    <div class="user-button">
                        <div class="row">
                            @if (auth()->check() && (auth()->user()->id() == $user->id()))
                                <a href="{{ route('users.profiles.edit') }}" class="btn btn-block btn-info">{{ trans('copy.a.edit') }}</a>
                            @else
                                <a href="{{ route('conversation.create', ['contact' => $user->id()]) }}" class="btn btn-block btn-info">
                                    <i class="fa fa-envelope"></i> {{ trans('copy.a.contact_message') }}
                                </a>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-8 m-b-md">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#horses" data-toggle="tab" aria-expanded="true">{{ trans('copy.titles.horses') }}</a></li>
                    <li><a href="#following" data-toggle="tab" aria-expanded="false">{{ trans('copy.titles.following') }}</a></li>
                    <li>
                        <a href="#companies" data-toggle="tab" aria-expanded="false">
                            {{ trans('copy.titles.companies_groups') }}
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="horses" class="tab-pane active">
                        <div class="panel-body">
                            <strong>{{ trans('copy.titles.horses') }}</strong>
                            <hr>
                            @foreach($user->horses() as $horse)
                                <div class="col-md-4">
                                    @include('horses._partials._horse_info')
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div id="following" class="tab-pane">
                        <div class="panel-body">
                            <strong>{{ trans('copy.titles.following') }}</strong>
                            <hr>
                            @foreach($user->follows() as $horse)
                                <div class="col-md-4">
                                    @include('horses._partials._horse_info')
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div id="companies" class="tab-pane">
                        <div class="panel-body">
                            <strong>{{ trans('copy.titles.companies_groups') }}</strong>
                            <hr>
                            @foreach ($user->companies()->chunk(3) as $companyChunk)
                                <div class="row">
                                    @foreach($companyChunk as $company)
                                        <div class="col-md-4">
                                            <div class="ibox-content text-center">
                                                <h4>{{ $company->name() }}</h4>
                                                <p>{{ trans('companies.types.' . $company->type()) }}</p>

                                                <div class="text-center">
                                                    <a class="btn btn-xs btn-primary" href="{{ route('companies.show', $company->slug()) }}">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
