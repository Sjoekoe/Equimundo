@extends('layout.admin')

@section('content')
    <div id="page-title">
        <h1 class="page-header text-overflow">Searches</h1>
    </div>
    <div id="page-content">
        <div class="panel">
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Term</th>
                                <th># searches</th>
                                <th>Current Results</th>
                                <th>Last Search</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($searches as $search)
                                <tr>
                                    <td>{{ $search->term() }}</td>
                                    <td>{{ $search->count() }}</td>
                                    <td>{{ $search->currentResults() }}</td>
                                    <td>{{ eqm_date($search->updated_at, 'd-m-Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer text-right">
                {{ $searches->render() }}
            </div>
        </div>
    </div>
@stop
