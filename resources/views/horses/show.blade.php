@extends('layout.app')

@section('content')
    <div class="page-content">
        @include('layout.partials.heading')

        <div class="col-lg-7 col-lg-offset-2" id="status-overview">
            <div v-for="status in statuses">
                @include('statuses.partials.status_js')
            </div>
            <pre>
                [[ horse.data.statuses ]]
                [[ $data | json ]]
            </pre>


            @if (! count($horse->statuses()))
                <p>{{ trans('copy.p.no_statuses') }}</p>
            @else
                @foreach($horse->statuses() as $status)
                    @include('statuses.partials.status')
                @endforeach
            @endif
        </div>
    </div>
    <script>
        var horse_id = {{ $horse->id() }};
        var user_id = {{ auth()->user()->id() }};
        var horse = {{ json_encode($horse) }};
        var statuses = {{ json_encode($horse->statuses()) }};
    </script>
@stop
