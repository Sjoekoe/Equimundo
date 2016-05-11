@extends('layout.admin', ['pageTitle' => true, 'title' => 'Horses'])

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Horses created
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div id="horseChart" style="height: 250px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Horses Growth
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div id="horseGrowth" style="height: 250px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="min-width">ID</th>
                                <th>Name</th>
                                <th>Breed</th>
                                <th>Created at</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($horses as $horse)
                                    <tr>
                                        <td>{{ $horse->id() }}</td>
                                        <td>{{ $horse->name() }}</td>
                                        <td>{{ trans('horses.breeds.' . $horse->breed()) }}</td>
                                        <td>{{ eqm_date($horse->created_at) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    {{ $horses->render() }}
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
    <script>
        new Morris.Line({
            // ID of the element in which to draw the chart.
            element: 'horseChart',
            // Chart data records -- each entry in this array corresponds to a point on
            // the chart.
            data: {{ json_encode($horseData) }},
            // The name of the data record attribute that contains x-values.
            xkey: 'date',
            // A list of names of data record attributes that contain y-values.
            ykeys: ['horses'],
            // Labels for the ykeys -- will be displayed when you hover over the
            // chart.
            labels: ['Horses created']
        });
        new Morris.Line({
            // ID of the element in which to draw the chart.
            element: 'horseGrowth',
            // Chart data records -- each entry in this array corresponds to a point on
            // the chart.
            data: {{ json_encode($horseGrowth) }},
            // The name of the data record attribute that contains x-values.
            xkey: 'date',
            // A list of names of data record attributes that contain y-values.
            ykeys: ['horses'],
            // Labels for the ykeys -- will be displayed when you hover over the
            // chart.
            labels: ['Horses created']
        });
    </script>
@stop
