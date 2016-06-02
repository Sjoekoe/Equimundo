@extends('layout.app', ['pageTitle' => true, 'title' => 'Articles for ' . $topic->title()])

@section('content')
    <div class="row">
        @foreach($articles as $article)
            <div class="col-md-4 col-sm-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <a href="{{ route('wiki.article.show', $article->slug()) }}" class="btn-link">
                            <h2>{{ $article->title() }}</h2>
                        </a>
                        <div class="small">
                            <i class="fa fa-eye"></i>
                            {{ $article->views() . ' views' }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop
