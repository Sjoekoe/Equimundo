@extends('layout.app')

@section('content')
    @include('users.partials.user_sidebar_left')
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">Edit Your Details</div>
            <div class="panel-body">
                @include('layout.partials.errors')

                {!! Form::open(['route' => 'users.profiles.update', 'class' => 'form-horizontal']) !!}

                <!-- First_name Form input -->
                <div class="form-group">
                    {!! Form::label('first_name', 'First Name:', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('first_name', Auth::user()->first_name, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <!-- Last_name Form input -->
                <div class="form-group">
                    {!! Form::label('last_name', 'Last Name:', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('last_name', Auth::user()->last_name, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <!-- Dob Form input -->
                <div class="form-group">
                    {!! Form::label('date_of_birth', 'Date Of Birth:', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('date_of_birth', Auth::user()->date_of_birth, ['class' => 'form-control', 'placeholder' => 'dd/mm/YYYY']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('country', 'Country', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-4">
                        {!! Form::select('country', Config::get('countries'), Auth::user()->country, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('gender', 'Gender',['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-4">
                        {!! Form::select('gender', ['F' => 'Female', 'M' => 'Male'], Auth::user()->gender, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('about', 'About You:', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::textarea('about', Auth::user()->about, ['class' => 'form-control', 'rows' => 3]) !!}
                    </div>
                </div>

                <!-- Submit button -->
                <div class="form-group">
                    <div class="col-sm-3 col-sm-offset-2">
                        {!! Form::submit('Save Profile', ['class' => 'btn btn-default form-control']) !!}
                    </div>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop