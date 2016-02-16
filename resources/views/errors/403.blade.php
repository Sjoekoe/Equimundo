@extends('layout.outer-app')

@section('content')
    <div id="container" class="cls-container">
        <div id="bg-overlay" class="bg-img" style="background-image: url({{ asset('images/horses.jpg') }})"></div>

        @include('layout.partials._outer_app_header')

        <div class="cls-content">
            <h1 class="error-code text-mint">Not allowed</h1>
            <p class="h4 text-thin pad-btm mar-btm">
                <i class="fa fa-exclamation-circle fa-fw text-danger"></i>
                You have no access to this page.
            </p>
            <div class="row mar-btm">
                {{ Form::open(['route' => 'search', 'class' => 'col-xs-12 col-sm-10 col-sm-offset-1']) }}
                {{ Form::text('search', null, ['placeholder' => trans('forms.placeholders.search') . '...', 'class' => 'form-control input-lg error-search']) }}
                {{ Form::close() }}
            </div>
            <br>
            <div class="pad-top"><a class="btn-link" href="{{ route('home') }}">Back to Homepage</a></div>
        </div>
    </div>
@stop
