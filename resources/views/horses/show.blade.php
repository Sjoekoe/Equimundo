@extends('layout.app')

@section('content')
    <div class="page-content" xmlns:v-bind="http://www.w3.org/1999/xhtml">
        @include('layout.partials.heading')

        <div class="col-lg-7 col-lg-offset-2">
            <horsefeed></horsefeed>

            <template id="horse-feed-template">
                @include('statuses.partials._status_template')
            </template>
        </div>
    </div>
    <script>
        var horse_id = {{ $horse->id() }};
    </script>
@stop
