@extends('layout.admin')

@section('content')
    <div id="page-title">
        <h1 class="page-header text-overflow">Dashboard</h1>
    </div>
    <div id="page-content">
        <div class="row">
            <div class="col-sm-6 col-lg-3">
                <div class="panel media pad-all">
                    <div class="media-left">
                        <span class="icon-wrap icon-wrap-sm icon-circle bg-success">
                            <i class="fa fa-user fa-2x"></i>
                        </span>
                    </div>
                    <div class="media-body">
                        <p class="text-2x mar-no text-thin">{{ $users }}</p>
                        <p class="text-muted mar-no">Registered users</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="panel media pad-all">
                    <div class="media-left">
                        <span class="icon-wrap icon-wrap-sm icon-circle bg-warning">
                            <i class="fa fa-comment fa-2x"></i>
                        </span>
                    </div>
                    <div class="media-body">
                        <p class="text-2x mar-no text-thin">{{ $statuses }}</p>
                        <p class="text-muted mar-no">Statuses</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="panel media pad-all">
                    <div class="media-left">
                        <span class="icon-wrap icon-wrap-sm icon-circle bg-pink">
                            <i class="fa fa-share-alt fa-2x"></i>
                        </span>
                    </div>
                    <div class="media-body">
                        <p class="text-2x mar-no text-thin">{{ $pedigrees }}</p>
                        <p class="text-muted mar-no">Pedigree connections</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="panel media pad-all">
                    <div class="media-left">
                        <span class="icon-wrap icon-wrap-sm icon-circle bg-info">
                            <i class="fa fa-photo fa-2x"></i>
                        </span>
                    </div>
                    <div class="media-body">
                        <p class="text-2x mar-no text-thin">{{ $horses }}</p>
                        <p class="text-muted mar-no">Horses</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
