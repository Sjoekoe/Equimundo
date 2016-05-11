@extends('layout.app', ['title' => trans('copy.titles.search_results', ['count' => $count, 'searchWord' => $searchWord]), 'pageTitle' => true])

@section('content')
    <div class="row">
        <div class="tabs-container">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#horses" data-toggle="tab" aria-expanded="true">
                        {{ trans('copy.titles.horses') }}
                        <i class="label label-danger">{{ count($horses) }}</i>
                    </a>
                </li>
                <li>
                    <a href="#users" data-toggle="tab" aria-expanded="false">
                        {{ trans('copy.titles.users') }}
                        <i class="label label-danger">{{ count($profiles) }}</i>
                    </a>
                </li>
                <li>
                    <a href="#companies" data-toggle="tab" aria-expanded="false">
                        {{ trans('copy.titles.companies_groups') }}
                        <i class="label label-danger">{{ count($companies) }}</i>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="horses" class="tab-pane active">
                    <div class="panel-body">
                        @if (count($horses))
                            @foreach($horses->chunk(4) as $horseChunk)
                                <div class="row">
                                    @foreach ($horseChunk as $horse)
                                        <div class="col-sm-3">
                                            @include('horses._partials._horse_info')
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
                </div>
                <div id="users" class="tab-pane">
                    <div class="panel-body">
                        @if (count($profiles))
                            @foreach($profiles->chunk(3) as $profileChunk)
                                <div class="row">
                                    @foreach ($profileChunk as $profile)
                                        <div class="col-md-4">
                                            <div class="ibox-content text-center">
                                                <h4>{{ $profile->fullName() }}</h4>
                                                <p>{{ $profile->about() }}</p>

                                                <div class="text-center">
                                                    <a class="btn btn-xs btn-primary" href="{{ route('users.profiles.show', $profile->slug()) }}">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
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
                <div id="companies" class="tab-pane">
                    <div class="panel-body">
                        @if (count($companies))
                            @foreach($companies->chunk(3) as $companyChunk)
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
                        @else
                            <p>{{ trans('copy.p.no_companies_groups_found') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
