@extends('layout.admin')

@section('content')
    <div id="page-title">
        <h1 class="page-header text-overflow">Users</h1>
    </div>
    <div id="page-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Users registered
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div id="userChart" style="height: 250px;"></div>
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
                                User Growth
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div id="userGrowth" style="height: 250px;"></div>
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
                                    <th>Status</th>
                                    <th>Member since</th>
                                    <th>Last Login</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->id() }}</td>
                                            <td>{{ $user->fullName() }}</td>
                                            <td>
                                                @if($user->activated())
                                                    <span class="label label-success">Activated</span>
                                                @else
                                                    <span class="label label-warning">Not Activated</span>
                                                @endif
                                            </td>
                                            <td>{{ eqm_date($user->created_at) }}</td>
                                            <td>{{ eqm_date($user->lastLogin()) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        {{ $users->render() }}
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
            element: 'userChart',
            // Chart data records -- each entry in this array corresponds to a point on
            // the chart.
            data: {{ json_encode($usersRegistered) }},
            // The name of the data record attribute that contains x-values.
            xkey: 'date',
            // A list of names of data record attributes that contain y-values.
            ykeys: ['users'],
            // Labels for the ykeys -- will be displayed when you hover over the
            // chart.
            labels: ['Users registered']
        });
        new Morris.Line({
            // ID of the element in which to draw the chart.
            element: 'userGrowth',
            // Chart data records -- each entry in this array corresponds to a point on
            // the chart.
            data: {{ json_encode($userGrowth) }},
            // The name of the data record attribute that contains x-values.
            xkey: 'date',
            // A list of names of data record attributes that contain y-values.
            ykeys: ['users'],
            // Labels for the ykeys -- will be displayed when you hover over the
            // chart.
            labels: ['Users registered']
        });
    </script>
@stop
