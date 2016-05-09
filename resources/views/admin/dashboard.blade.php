@extends('layout.admin', ['pageTitle' => true, 'title' => 'Dashboard'])

@section('content')
    <div class="row">
        <admindash></admindash>

        <template id="admindash">
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <a href="{{ route('admin.users') }}">
                        <div class="widget style1 lazur-bg">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-8 text-right">
                                    <span> Registered users </span>
                                    <h2 class="font-bold">@{{ users }}</h2>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="widget style1 navy-bg">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-comment fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-right">
                                <span> Statuses </span>
                                <h2 class="font-bold">{{ $statuses }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="widget style1 yellow-bg">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-share-alt fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-right">
                                <span> Pedigree connections </span>
                                <h2 class="font-bold">{{ $pedigrees }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <a href="{{ route('admin.horses.index') }}">
                        <div class="widget style1 blue-bg">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-photo fa-5x"></i>
                                </div>
                                <div class="col-xs-8 text-right">
                                    <span> Horses </span>
                                    <h2 class="font-bold">{{ $horses }}</h2>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <a href="{{ route('admin.searches.index') }}">
                        <div class="widget style1 red-bg">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-search fa-5x"></i>
                                </div>
                                <div class="col-xs-8 text-right">
                                    <span> Searches performed </span>
                                    <h2 class="font-bold">{{ $searchResults }}</h2>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="widget style1 black-bg">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-microphone fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-right">
                                <span> Conversations </span>
                                <h2 class="font-bold">{{ $conversations }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="widget style1 blue-bg">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-picture-o fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-right">
                                <span> Pictures uploaded </span>
                                <h2 class="font-bold">{{ $pictures }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="widget style1 navy-bg">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-envelope-o fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-right">
                                <span> Friends invited </span>
                                <h2 class="font-bold">@{{ invites }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="widget style1 lazur-bg">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-commenting-o fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-right">
                                <span> Comments placed </span>
                                <h2 class="font-bold">@{{ comments }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="widget style1 yellow-bg">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-thumbs-o-up fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-right">
                                <span> Likes given </span>
                                <h2 class="font-bold">@{{ likes }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="widget style1 red-bg">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-thumbs-o-down fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-right">
                                <span> Unactivated users </span>
                                <h2 class="font-bold">{{ $unactivatedUsers }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="widget style1 white-bg">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-money fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-right">
                                <span> Advertisements </span>
                                <h2 class="font-bold">{{ $advertisements }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <a href="{{ route('admin.companies.index') }}">
                        <div class="widget style1 blue-bg">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-industry fa-5x"></i>
                                </div>
                                <div class="col-xs-8 text-right">
                                    <span> Companies / Groups </span>
                                    <h2 class="font-bold">{{ $companies }}</h2>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </template>

    </div>
    <script>
        var invites = {{ $invites }};
        var comments = {{ $comments }};
        var likes = {{ $likes }};
        var users = {{ $users }};
    </script>
@stop
