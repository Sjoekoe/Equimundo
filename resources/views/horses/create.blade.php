@extends('layout.app')

@section('content')
    @include('users.partials/user_sidebar_left')

    <div class="col-md-6 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">Create a horse</div>
            <div class="panel-body">
                @include('layout.partials.errors')

                {!! Form::open(['route' => 'horses.create', 'class' => 'form-horizontal', 'files' => 'true']) !!}
                    <!-- Name Form input -->
                    <div class="form-group">
                        {!! Form::label('name', 'Name:', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('profile_pic', 'Profile Picture', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::file('profile_pic') !!}
                        </div>
                    </div>

                    <!-- Gender Form Input -->
                    <div class="form-group">
                        {!! Form::label('gender', 'Gender:', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('gender', Lang::get('horses.genders'), null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <!-- Breed Form input -->
                    <div class="form-group">
                        {!! Form::label('breed', 'Breed:', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('breed', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <!-- Height Form input -->
                    <div class="form-group">
                        {!! Form::label('height', 'Height:', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('height', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <!-- Color Form Input -->
                    <div class="form-group">
                        {!! Form::label('color', 'Color:', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('color', Lang::get('horses.colors'), null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <!-- Date_of_birth Form input -->
                    <div class="form-group">
                        {!! Form::label('date_of_birth', 'Date Of Birth:', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('date_of_birth', null, ['class' => 'form-control', 'placeholder' => 'dd/mm/yyy']) !!}
                        </div>
                    </div>

                    <!-- Life_number Form input -->
                    <div class="form-group">
                        {!! Form::label('life_number', 'Life Number:', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('life_number', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <!-- Submit button -->
                    <div class="form-group">
                        <div class="col-sm-3 col-sm-offset-2">
                            {!! Form::submit('Create Horse', ['class' => 'btn btn-default form-control']) !!}
                        </div>
                    </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop