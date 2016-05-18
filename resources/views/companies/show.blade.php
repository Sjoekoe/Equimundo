@extends('layout.app', ['title' => $company->name(), 'pageTitle' => true])

@section('content')
    <showcompany></showcompany>

    <template id="show-company">
        <div class="row">
            <div class="col-md-4">
                <div class="ibox float-e-margins">
                    <div class="ibox-content profile-content">
                        @if (auth()->check())

                            @if (! auth()->user()->isInCompanyTeam($company))
                                <template v-if="company.is_followed_by_user">
                                    <button class="btn btn-block btn-info" @click="unfollow">{{ trans('copy.a.unfollow') }}</button>
                                </template>
                                <template v-else>
                                    <button class="btn btn-block btn-info" @click="follow">{{ trans('copy.a.follow') }}</button>
                                </template>
                            @elseif(auth()->user()->isCompanyAdmin($company))
                                <a href="{{ route('company.edit', $company->slug()) }}" class="btn btn-block btn-info">
                                    {{ trans('copy.titles.edit') }}
                                </a>
                            @endif
                            <button class="btn btn-block btn-info" data-toggle="modal" href="#horseModal">{{ trans('copy.a.add_horse') }}</button>
                                <div id="horseModal" class="modal fade" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-12"><h3 class="m-t-none m-b">{{ trans('copy.titles.add_horse_to_company') }}</h3>

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
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <hr>
                        @endif
                        <h5>{{ trans('copy.titles.address') }}</h5>
                        <address>
                            @{{ address.street }} <br>
                            @{{ address.zip + ' ' + address.city }} <br>
                            @{{ address.state + ', ' + address.country }}
                        </address>
                        <div id="map" style="width: 100%; height: 200px"></div>
                        <hr>
                        <p>
                            <i class="fa fa-envelope"></i> <a href="mailto:@{{ company.email }}">@{{ company.email }}</a>
                        </p>
                        <p>
                            <i class="fa fa-laptop"></i> <a v-bind:href="company.website" target="_blank">@{{ company.website }}</a>
                        </p>
                        <p>
                            <i class="fa fa-phone"></i> <a href="tel:@{{ company.telephone }}">@{{ company.telephone }}</a>
                        </p>
                        <hr>
                        <h5>{{ trans('copy.titles.about_us') }}</h5>
                        <p v-html="company.about"></p>
                    </div>
                </div>

                <div class="ibox e-float-margins">
                    <div class="ibox-content profile-content">
                        <h5>{{ trans('copy.titles.horses') }}</h5>
                        <hr>
                        <ul class="list-unstyled" v-for="horse in horses">
                            <a href="/horses/@{{ horse.horseRelation.data.slug }}" class="text-mint">
                                @{{ horse.horseRelation.data.name }}
                            </a>
                        </ul>
                    </div>
                </div>

                <div class="ibox float-e-margins">
                    <div class="ibox-content profile-content">
                        <h5>{{ trans('copy.titles.followers') }}</h5>
                        <hr>
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
            <div class="col-md-8">
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
                                                <img v-bind:src="image" alt="" class="profile-image">
                                                <button class="btn btn-sm btn-danger" v-on:click="removeImage">X</button>
                                            </div>
                                        </div>
                                        <br>
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
        </div>
    </template>
@stop

