@extends('layout.admin')

@section('content')
    <div id="page-title">
        <h1 class="page-header text-overflow">Companies / Groups</h1>
    </div>
    <div id="page-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Companies / Groups
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div id="companiesChart" style="height: 250px;"></div>
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
                                Companies / Groups Growth
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div id="companiesGrowth" style="height: 250px;"></div>
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
                                        <th>Type</th>
                                        <th>Created at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($companies as $company)
                                        <tr>
                                            <td>{{ $company->id() }}</td>
                                            <td>{{ $company->name() }}</td>
                                            <td>{{ trans('companies.types.' . $company->type()) }}</td>
                                            <td>{{ eqm_date($company->createdAt()) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        {{ $companies->render() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
    <script>
        new Morris.Line({
            // ID of the element in which to draw the chart.
            element: 'companiesChart',
            // Chart data records -- each entry in this array corresponds to a point on
            // the chart.
            data: {{ json_encode($companiesRegistered) }},
            // The name of the data record attribute that contains x-values.
            xkey: 'date',
            // A list of names of data record attributes that contain y-values.
            ykeys: ['companies'],
            // Labels for the ykeys -- will be displayed when you hover over the
            // chart.
            labels: ['Companies registered']
        });
        new Morris.Line({
            // ID of the element in which to draw the chart.
            element: 'companiesGrowth',
            // Chart data records -- each entry in this array corresponds to a point on
            // the chart.
            data: {{ json_encode($companyGrowth) }},
            // The name of the data record attribute that contains x-values.
            xkey: 'date',
            // A list of names of data record attributes that contain y-values.
            ykeys: ['companies'],
            // Labels for the ykeys -- will be displayed when you hover over the
            // chart.
            labels: ['Companies registered']
        });
    </script>
@stop
