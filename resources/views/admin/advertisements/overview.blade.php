@extends('layout.admin', ['pageTitle' => true, 'title' => 'Advertisements overview'])

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Advertisers
                    </h3>
                </div>
                <div class="panel-body text-center">
                    <div class="row">
                        # advertisers: {{ count($companies) }}
                    </div>
                    <div class="row">
                        <div id="company-locations" class="morris-donut"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Advertisements
                    </h3>
                </div>
                <div class="panel-body text-center">
                    <div class="row">
                        # Advertisements: {{ count($advertisements) }}
                    </div>
                    <div class="row">
                        <div id="advertisements" class="morris-donut"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Payments
                    </h3>
                </div>
                <div class="panel-body text-center">
                    <div class="row">
                        <div id="payments" class="morris-donut"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
    <script>
        Morris.Donut({
            element: 'company-locations',
            data: {{ json_encode($countryData) }},
            colors: {{ json_encode($countryColors) }},
            resize:true
        });

        Morris.Donut({
            element: 'advertisements',
            data: {{ json_encode($advertisementData) }},
            colors: {{ json_encode($advertisementColors) }},
            resize:true
        });

        Morris.Donut({
            element: 'payments',
            data: {{ json_encode($paymentData) }},
            colors: {{ json_encode($paymentColors) }},
            resize:true
        });
    </script>
@stop
