@extends('layout.outer-app')

@section('content')
    <div class="passwordBox text-center animated fadeInDown">
        <div class="ibox-content">
            <h1>500</h1>
            <h3 class="font-bold">Oooops!</h3>

            <div class="error-desc">
                An error has occured. Our technical departement is working on it as we speak. Please try again later.

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
