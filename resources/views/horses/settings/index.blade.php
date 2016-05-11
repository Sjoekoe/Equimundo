@extends('layout.app', ['title' => trans('copy.titles.settings'), 'pageTitle' => true])

@section('content')
    <div class="row">
        <div class="col-md-4">
            @include('users.partials._settings_navigation')
        </div>
        <div class="col-md-8">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        {{ trans('copy.titles.horses') }}
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="alert alert-info media fade in">
                        <div class="media-left">
                            <span class="icon-wrap icon-wrap-xs icon-circle alert-icon">
                                <i class="fa fa-warning fa-lg"></i>
                            </span>
                        </div>
                        <div class="media-body">
                            <p class="alert-message">
                                {{ trans('copy.p.unlink_horse') }} <br>
                                {{ trans('copy.p.delete_horse') }}
                            </p>
                        </div>
                    </div>
                    @foreach (auth()->user()->horses() as $horse)
                        <h4 class="text-thin pull-left">
                            {{ $horse->name() }}
                        </h4>
                        <div class="pull-right">
                            <a href="{{ route('horses.settings.unlink', $horse->id()) }}" class="btn btn-warning btn-labeled fa fa-unlink">
                                {{ trans('copy.a.unlink') }}
                            </a>
                            <a href="{{ route('horses.settings.delete', $horse->id()) }}" class="btn btn-danger btn-labeled fa fa-trash">
                                {{ trans('copy.a.delete') }}
                            </a>
                        </div>
                        <div class="clearfix"></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@stop
