@extends('layout.app')

@section('content')
    <div class="col-lg-7 col-lg-offset-2 col-sm-12 mar-top">
        <singlestatus></singlestatus>

        <template id="single-status">
            @include('statuses.partials._status_template')
        </template>
    </div>

    <script>
        var status_id = {{ $status->id() }}
    </script>
@stop
