@extends('layout.admin')

@section('content')
    <div id="page-title">
        <h1 class="page-header text-overflow">Companies</h1>
    </div>
    <div id="page-content">
        <div class="row">
            <div class="col-lg-12">
                <advertisingcompaniestable></advertisingcompaniestable>
                <template id="advertising-companies">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="pad-btm form-inline">
                                <a href="{{ route('admin.advertisements.companies.create') }}" class="btn btn-mint btn-labeled fa fa-plus">
                                    Add
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th class="min-width">ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Telephone</th>
                                        <th>Tax</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="company in companies">
                                        <td>@{{ company.id }}</td>
                                        <td>@{{ company.name }}</td>
                                        <td>@{{ company.email }}</td>
                                        <td>@{{ company.telephone }}</td>
                                        <td>@{{ company.tax }}</td>
                                        <td>
                                            <a href="/admin/advertisements/companies/@{{ company.id }}">
                                                <i class="fa fa-search"></i>
                                            </a>
                                            <a href="#">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="#" @click="delete(company)">
                                                <i class="fa fa-trash"></i>
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
