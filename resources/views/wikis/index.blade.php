@extends('layout.app', ['pageTitle' => true, 'title' => 'Wiki pages'])

@section('content')
    <div class="row">
        @foreach($topics as $topic)
            <div class="col-md-4 col-sm-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <a href="{{ route('wiki.topic.show', $topic->id()) }}" class="btn-link">
                            <h2>{{ $topic->title() }}</h2>
                        </a>
                        <div class="small">
                            {{ count($topic->articles()) . ' Articles' }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop
