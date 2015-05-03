@extends('layout.app')

@section('content')

                    @include('layout.partials.errors')

                    {{ Form::open(['class' => 'form-horizontal']) }}
                    <!-- Name Form input -->
                    <div class="form-group">
                        {{ Form::label('username', 'Username:', ['class' => 'col-md-4 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::text('username', null, ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <!-- Email Form input -->
                    <div class="form-group">
                        {{ Form::label('email', 'E-Mail Address:', ['class' => 'col-md-4 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::text('email', null, ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <!-- Password Form input -->
                    <div class="form-group">
                        {{ Form::label('password', 'Password:', ['class' => 'col-md-4 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::password('password', ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <!-- Password_confirmation Form input -->
                    <div class="form-group">
                        {{ Form::label('password_confirmation', 'Password Confirmation:', ['class' => 'col-md-4
                        control-label']) }}
                        <div class="col-md-6">
                            {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <!-- Submit button -->
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            {{ Form::submit('Sign Up', ['class' => 'btn btn-default']) }}
                        </div>
                    </div>

                    {{ Form::close() }}

@endsection
