@extends('layout.app')

@section('content')
    @include('layout.partials.heading')

    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        {{ trans('copy.titles.followers') }}
                    </h3>
                </div>
                <div class="panel-body">
                    @if (count($horse->followers()))
                        @foreach($horse->followers->chunk(3) as $profileChunk)
                            <div class="row">
                                @foreach ($profileChunk as $profile)
                                    <div class="col-md-4">
                                        <div class="ibox-content text-center">
                                            <h4>{{ $profile->fullName() }}</h4>
                                            <p>{{ $profile->about() }}</p>

                                            <div class="text-center">
                                                <a class="btn btn-xs btn-primary" href="{{ route('users.profiles.show', $profile->slug()) }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @else
                        <p>{{ trans('copy.p.no_followers') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
