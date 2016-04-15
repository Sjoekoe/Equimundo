@extends('layout.left-aside')

@section('content')
    <showcompany></showcompany>

    <template id="show-company">
        <div id="page-content">
            <div class="row">
                <div class="col-sm-12 col-md-7">
                    <div class="panel">
                        <div class="panel-body">
                            <textarea class="form-control" rows="2" placeholder="What are you thinking?"></textarea>
                            <div class="mar-top clearfix">
                                <button class="btn btn-sm btn-primary pull-right" type="submit"><i class="fa fa-pencil fa-fw"></i> Share</button>
                                <a class="btn btn-trans btn-icon fa fa-camera add-tooltip" href="#" data-original-title="Add Photo" data-toggle="tooltip"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-5">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Horses
                            </h3>
                        </div>
                        <div class="panel-body">
                            Oplijsting
                        </div>
                    </div>
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Users
                            </h3>
                        </div>
                        <div class="panel-body">
                            <ul v-for="user in users" class="list-unstyled">
                                <li>
                                    <a href="/user/@{{ user.userRelation.data.slug }}" class="text-mint">
                                        @{{ user.userRelation.data.first_name + ' ' +  user.userRelation.data.last_name}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <aside id="aside-container">
            <div id="aside">
                <div class="nano">
                    <div class="nano-content">
                        <div class="text-center pad-all">
                            <h4 class="text-lg text-overflow mar-no">@{{ company.name }}</h4>

                            <div class="pad-ver btn-group">
                                <a title="" href="mailto:@{{  company.email }}" class="btn btn-icon btn-hover-warning fa fa-envelope icon-lg add-tooltip" data-original-title="Email" data-container="body"></a>
                                <a title="" v-bind:href="company.website" target="_blank" class="btn btn-icon btn-hover-warning fa fa-laptop icon-lg add-tooltip" data-original-title="Website" data-container="body"></a>
                                <a href="tel:@{{ company.telephone }}" class="btn btn-icon btn-hover-warning fa fa-phone icon-lg add-tooltip" data-original-title="Telephone" data-container="body"></a>
                            </div>
                            @if (auth()->check())

                                    <template v-if="company.is_followed_by_user">
                                        <button class="btn btn-block btn-mint" @click="unfollow">Unfollow</button>
                                    </template>
                                    <template v-else>
                                        <button class="btn btn-block btn-mint" @click="follow">Follow</button>
                                    </template>
                            @endif
                        </div>

                        <hr>
                        <div class="pad-hor">
                            <h5>Address</h5>
                            <address>
                                @{{ address.street }} <br>
                                @{{ address.zip + ' ' + address.city }} <br>
                                @{{ address.state + ', ' + address.country }}
                            </address>
                            <div id="map" style="width: 100%; height: 200px"></div>
                        </div>
                        <hr>
                        <div class="pad-hor">
                            <h5>{{ trans('copy.titles.about_me') }}</h5>
                            <small class="text-thin" v-html="company.about">

                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </template>
@stop

