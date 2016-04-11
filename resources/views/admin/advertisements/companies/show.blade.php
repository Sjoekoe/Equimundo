@extends('layout.admin')

@section('content')
    <div id="page-title">
        <h1 class="page-header text-overflow">{{ $company->name() }}</h1>
    </div>
    <div id="page-content">
        <advertisingcompany></advertisingcompany>

        <template id="advertising-company">
            <div class="col-md-6">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Company Details
                        </h3>
                    </div>
                    <div class="panel-body">
                        Name: @{{ company.name }} <br>
                        Email: <a href="mailto:@{{ company.email }}" class="text-mint">@{{ company.email }}</a> <br>
                        Telephone: @{{ company.telephone }} <br>
                        Tax: @{{ company.tax }}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Primary Contact
                        </h3>
                    </div>
                    <div class="panel-body">
                        First name: @{{ contact.first_name }} <br>
                        Last name: @{{ contact.last_name }} <br>
                        Email: <a href="mailto:@{{ contact.email }}" class="text-mint">@{{ contact.email }}</a> <br>
                        Telephone: @{{ contact.telephone }}
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Location
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div id="map" style="width: 100%; height: 400px"></div>
                    </div>
                </div>
            </div>
        </template>
    </div>
@stop
