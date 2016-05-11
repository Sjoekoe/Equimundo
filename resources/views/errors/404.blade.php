@extends('layout.outer-app')

@section('content')
    <div class="passwordBox text-center animated fadeInDown">
        <div class="ibox-content">
            <h1>404</h1>
            <h3 class="font-bold">Not found</h3>

            <div class="error-desc">
                Sorry, but the page you are looking for has not been found on our server.

                {{ Form::open(['route' => 'search', 'class' => 'form-inline m-t']) }}
                    {{ Form::text('search', null, ['placeholder' => trans('forms.placeholders.search') . '...', 'class' => 'form-control']) }}
                    <button type="submit" class="btn btn-primary">Search</button>
                {{ Form::close() }}
                <br>
                <a href="{{ route('home') }}" class="btn btn-primary btn-block">Back to Homepage</a>
            </div>
        </div>
    </div>
@stop
