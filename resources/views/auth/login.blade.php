@extends('layout.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Login</div>
                    <div class="panel-body">
                        @include('layout.partials.errors')

                        {{ Form::open(['route' => 'login', 'class' => 'form-horizontal']) }}

                        <!-- Email Form input -->
                        <div class="form-group">
                            {{ Form::label('email', 'Email:', ['class' => 'col-md-4 control-label']) }}
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

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        {{ Form::checkbox('remember', 'Remember Me') }}
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit button -->
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {{ Form::submit('Login', ['class' => 'btn btn-default', 'style' => 'margin-right:
                                15px;']) }}
                                <a href="/password/email">Forgot Your Password?</a>
                            </div>
                        </div>

                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
