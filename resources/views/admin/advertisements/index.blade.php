@extends('layout.admin')

@section('content')
    <div id="page-title">
        <h1 class="page-header text-overflow">Advertisements</h1>
    </div>
    <div id="page-content">
        <div class="row">
            <div class="col-lg-12">
                <advertisementstable></advertisementstable>

                <template id="advertisements-table">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="pad-btm form-inline">
                                <a href="{{ route('admin.advertisements.create') }}" class="btn btn-mint btn-labeled fa fa-plus">
                                    Add
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>From</th>
                                            <th>Till</th>
                                            <th>Paid</th>
                                            <th>Amount</th>
                                            <th>Clicks</th>
                                            <th>Views</th>
                                            <th>Type</th>
                                            <th>Company</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="advertisement in advertisements">
                                            <td>@{{ advertisement.id }}</td>
                                            <td>@{{ advertisement.start | timeFormat}}</td>
                                            <td>@{{ advertisement.end | timeFormat}}</td>
                                            <td>
                                                <i class="fa" v-bind:class="{ 'fa-check' : advertisement.paid, 'fa-remove' : ! advertisement.paid}"></i>
                                            </td>
                                            <td>@{{ advertisement.amount }}</td>
                                            <td>@{{ advertisement.clicks }}</td>
                                            <td>@{{ advertisement.views }}</td>
                                            <td>@{{ advertisement.type }}</td>
                                            <td>@{{ advertisement.companyRelation.data.name }}</td>
                                            <td>
                                                <a href="/admin/advertisements/@{{ advertisement.id }}">
                                                    <i class="fa fa-search"></i>
                                                </a>
                                                <a href="#" @click="delete(advertisement)">
                                                    <i class="fa fa-remove"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
@stop
