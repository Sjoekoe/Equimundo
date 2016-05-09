@extends('layout.admin', ['pageTitle' => true, 'title' => 'Show advertisement'])

@section('content')
    <showadvertisement></showadvertisement>

    <template id="show-advertisement">
        <div class="row">
            <div class="col-md-6">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Information
                        </h3>
                    </div>
                    <div class="panel-body">
                        <p>
                            <i class="text-semibold">Company: </i>@{{ advertisement.companyRelation.data.name }}
                        </p>
                        <p>
                            <i class="text-semibold">Company Email: </i>
                            <a href="mailto:@{{ advertisement.companyRelation.data.email }}" class="text-mint">
                                @{{ advertisement.companyRelation.data.email }}
                            </a>

                        </p>
                        <p>
                            <i class="text-semibold">Contact Person: </i>@{{ contact.first_name + ' ' + contact.last_name }}
                        </p>
                        <p>
                            <i class="text-semibold">Contact Email: </i>
                            <a href="mailto:@{{ contact.email }}" class="text-mint">
                                @{{ contact.email }}
                            </a>
                        </p>
                        <p>
                            <i class="text-semibold">Contact Telephone: </i>@{{ contact.telephone }}
                        </p>
                        <p>
                            <i class="text-semibold">Type: </i>@{{ advertisement.type }}
                        </p>
                        <p>
                            <i class="text-semibold">Website: </i>
                            <a href="@{{ advertisement.website }}" target="_blank" class="text-mint">
                                @{{ advertisement.website }}
                            </a>

                        </p>
                        <p>
                            <i class="text-semibold">Amount: </i>€ @{{ advertisement.amount }}
                        </p>
                        <p>
                            <i class="text-semibold">Paid: </i>@{{ advertisement.paid }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Statistics</h3>
                    </div>
                    <div class="panel-body text-center">
                        <div class="col-md-12">
                            <p class="text-muted" v-if="advertisement.views > 0">Average cost per image: € @{{ advertisement.amount / advertisement.views }}</p>
                            <p class="text-muted" v-if="advertisement.clicks > 0">Average cost per click: € @{{ advertisement.amount / advertisement.clicks }}</p>
                        </div>
                        <div class="col-md-12" >
                            <div id="morris-donut" class="morris-donut"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
@stop

@section('footer')
    <script>
        Morris.Donut({
            element: 'morris-donut',
            data: [
                {label: "Clicks", value: window.equimundo.advertisement.clicks},
                {label: "Views", value: window.equimundo.advertisement.views},
            ],
            colors: [
                '#579DDB',
                '#46B9D8',
            ],
            resize:true
        });
    </script>
@stop
