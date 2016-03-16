<header id="navbar">
    <div id="navbar-container" class="boxed">
        <!--Brand logo & name-->
        <!--================================-->
        <div class="navbar-header">
            <a href="{{ route('home') }}" class="navbar-brand">
                <div class="brand-title">
                    <span class="brand-text">Equimundo</span>
                    <button class="text-muted" type="button"><i class="fa fa-search"></i></button>
                </div>
            </a>
        </div>
        <!--================================-->
        <!--End brand logo & name-->

        <!--Navbar Dropdown-->
        <!--================================-->
        <div class="navbar-content clearfix">
            <ul class="nav navbar-top-links pull-left">
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle" id="js-toggle-search">
                        <i class="fa fa-search fa-lg"></i>
                    </a>
                </li>
            </ul>

            <ul class="nav navbar-top-links pull-right">
                @if (auth()->check())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ trans('copy.titles.horses') }} <b class="caret"></b></a>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right with-arrow">
                            <div class="pad-all bord-btm">
                                <p class="text-lg text-muted text-thin mar-no">{{ trans('copy.titles.horse_count', [count(auth()->user()->horses())]) }}</p>
                            </div>
                            <div class="nano scrollable">
                                <div class="nano-content">
                                    <ul class="head-list">
                                        @foreach(Auth::user()->horses() as $horse)
                                            <li>
                                                <a href="{{ route('horses.show', $horse->slug()) }}" class="media">
                                                    <div class="media-left">
                                                        @if ($horse->getProfilePicture())
                                                            <img src="{{ route('file.picture', $horse->getProfilePicture()->id()) }}" alt="{{ $horse->name() }}" class="img-circle img-sm">
                                                        @else
                                                            <img src="{{ asset('images/eqm.png') }}" alt="{{ $horse->name() }}" class="img-circle img-sm">
                                                        @endif
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="text-nowrap">{{ $horse->name() }}</div>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                        <div class="pad-all bord-top">
                                            <a href="{{ route('horses.create') }}" class="btn-link text-dark box-block">
                                                <i class="fa fa-plus-square-o fa-lg pull-right"></i>{{ trans('copy.a.create_a_horse') }}
                                            </a>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!--Messages Dropdown-->
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                            <i class="fa fa-envelope fa-lg"></i>
                            @if (auth()->user()->countUnreadMessages())
                                <span class="badge badge-header badge-danger">{{ auth()->user()->countUnreadMessages() }}</span>
                            @endif
                        </a>

                        <!--Message dropdown menu-->
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right with-arrow">
                            <div class="pad-all bord-btm">
                                <p class="text-lg text-muted text-thin mar-no">{{ trans('copy.titles.count_messages', [auth()->user()->countUnreadMessages()]) }}</p>
                            </div>
                            <div class="nano scrollable">
                                <div class="nano-content">
                                    <ul class="head-list">
                                        @foreach(auth()->user()->conversations() as $conversation)
                                            @if (! $conversation->isDeletedForUser(auth()->user()))
                                                <li>
                                                    <a href="{{ route('conversation.show', $conversation->id()) }}" class="media">
                                                        <div class="media-left">
                                                            <p>{{ substr($conversation->contactPerson(auth()->user())->fullName(), 0, 1) }}</p>
                                                        </div>
                                                        <div class="media-body">
                                                            <div class="text-nowrap">{{ $conversation->subject() }}</div>
                                                            <small class="text-muted">{{ eqm_translated_date($conversation->updated_at)->diffForHumans() }}</small>
                                                        </div>
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul    >
                                </div>
                            </div>

                            <!--Dropdown footer-->
                            <div class="pad-all bord-top">
                                <a href="{{ route('conversation.index') }}" class="btn-link text-dark box-block">
                                    <i class="fa fa-angle-right fa-lg pull-right"></i>{{ trans('copy.titles.go_to_inbox') }}
                                </a>
                            </div>
                        </div>
                    </li>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End message dropdown-->

                    <notedrop></notedrop>

                    @include('layout.partials._notifications_dropdown')

                    <!--User dropdown-->
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <li id="dropdown" class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
                            <i class="fa fa-user fa-lg"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right with-arrow panel-default">
                            <!-- User dropdown menu -->
                            <ul class="head-list">
                                @if (auth()->user()->isAdmin())
                                    <li>
                                        <a href="{{ route('admin.dashboard') }}">
                                            <i class="fa fa-shield fa-fw fa-lg"></i> Admin Panel
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{ route('users.profiles.show', auth()->user()->slug()) }}">
                                        <i class="fa fa-user fa-fw fa-lg"></i> {{ trans('copy.titles.profile') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('conversation.index') }}">
                                        @if (Auth::user()->countUnreadNotifications())
                                            <span class="badge badge-mint pull-right">{{ Auth::user()->countUnreadMessages() }}</span>
                                        @endif
                                        <i class="fa fa-envelope fa-fw fa-lg"></i> {{ trans('copy.titles.messages') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('settings.index') }}">
                                        <i class="fa fa-gear fa-fw fa-lg"></i> {{ trans('copy.a.settings') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}">
                                        <i class="fa fa-sign-out fa-fw fa-lg"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End user dropdown-->
                @else
                    <li>
                        <a href="{{ route('register') }}">Register</a>
                    </li>
                    <li>
                        <a href="{{ route('login') }}">Login</a>
                    </li>
                @endif
            </ul>
        </div>
        <!--================================-->
        <!--End Navbar Dropdown-->

    </div>
</header>
