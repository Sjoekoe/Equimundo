@extends('layout.admin')

@section('content')
    <div class="row">
        @foreach($users as $user)
            <p>{{ $user->fullName() }}</p>
        @endforeach
    </div>
@stop
