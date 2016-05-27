@extends('layout.app', ['pageTitle' => true, 'title' => $article->title()])

@section('content')
    <div class="row">
        <div class="col-lg-10 col-sm-12 col-lg-offset-1">
            <div class="ibox">
                <div class="ibox-content">
                    {{ $article->body() }}
                    <div class="row">
                        <div class="small text-right">
                            <i class="fa fa-eye"> </i> {{ $article->views() }} views
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
