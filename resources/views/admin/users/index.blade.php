@extends('layout.admin')

@section('content')
    <div class="row">
        @foreach($users as $user)
            <p>{{ $user->username }}</p>
        @endforeach
    </div>
@stop
