@extends('layout.left-aside')

@section('content')
    <showcompany></showcompany>

    <template id="show-company">
        <div id="page-content">
            <div class="row">
                <div class="col-sm-12 col-md-7">
                    @if (auth()->check() && auth()->user()->isInCompanyTeam($company))
                        <div class="panel">
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="row mar-top">
                                            <textarea name="body" id="" cols="30" rows="3" class="form-control" placeholder="{{ trans('forms.placeholders.what_you_been_doing') }}" v-model="body"></textarea>
                                            <small class="help-block text-danger text-left" v-if="errors.body"><i class="fa fa-exclamation-circle"></i> @{{ errors.body }}</small>
                                        </div>
                                        <div class="row mar-top">
                                            <div class="col-sm-6 pad-no">
                                                <div class="image-upload">
                                                    <label for="picture">
                                                        <i class="btn btn-trans btn-icon fa fa-camera add-tooltip"></i>
                                                    </label>
                                                    <input id="picture" type="file" v-model="upload" @change="onFileChange">
                                                </div>
                                                <div v-if="image" >
                                                    <img v-bind:src="image" alt="" class="img-lg img-border">
                                                    <button class="btn btn-sm btn-danger" v-on:click="removeImage">X</button>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 pad-no">
                                                <template v-if="submitting">
                                                    <button class="btn btn-sm btn-info pull-right" disabled><i class="fa fa-spinner fa-spin"></i></button>
                                                </template>
                                                <template v-else>
                                                    <button type="submit" class="btn btn-sm btn-info pull-right" v-on:click="submit($event)">{{ trans('forms.buttons.post_status') }}</button>
                                                </template>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                    @include('statuses.partials._status_template')
                </div>
                <div class="col-sm-12 col-md-5">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Horses
                            </h3>
                        </div>
                        <div class="panel-body">
                            @if (auth()->check())
                                <ul class="list-unstyled">
                                    @foreach(auth()->user()->horses() as $horse)
                                        <li style="margin-top: 5px;">
                                            <a href="{{ route('horses.show', $horse->slug()) }}" class="text-mint">
                                                {{ $horse->name() }}
                                            </a>

                                            @if ($horse->isFollowingCompany($company))
                                                <a href="{{ route('companies.follow', [$company->slug(), $horse->id()]) }}">
                                                    <span class="label label-danger pull-right">
                                                        <i class="fa fa-remove"></i>
                                                    </span>
                                                </a>
                                            @else
                                                <a href="{{ route('companies.follow', [$company->slug(), $horse->id()]) }}">
                                                    <span class="label label-info pull-right">
                                                        <i class="fa fa-plus"></i>
                                                    </span>
                                                </a>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                                <hr>
                            @endif
                            <ul class="list-unstyled" v-for="horse in horses">
                                <a href="/horses/@{{ horse.horseRelation.data.slug }}" class="text-mint">
                                    @{{ horse.horseRelation.data.name }}
                                </a>
                            </ul>
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

