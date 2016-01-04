<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="{{ route('home') }}" class="navbar-brand navbar-brand-centered">Equimundo</a>
        </div>
        <div class="nav navbar-nav navbar-left">
            @if (auth()->check())
                {{ Form::open(['route' => 'search']) }}
                    {{ Form::text('search', null, ['placeholder' => trans('forms.placeholders.search') . '...', 'class' => 'form-control']) }}
                {{ Form::close() }}
            @endif
        </div>
        <div class="nav navbar-nav navbar-right">
            @if (Auth::guest())
                <ul class="navbar-nav nav">
                    <li><a href="{{ route('login') }}">{{ trans('copy.a.sign_in') }}</a></li>
                    <li><a href="{{ route('register') }}">{{ trans('copy.a.sign_up') }}</a></li>
                </ul>
            @else
                <ul class="nav navbar-nav">
                    <li>
                        <a href="{{ route('conversation.index') }}">
                            {{ trans('copy.a.messages') }}

                            @if (Auth::user()->hasUnreadMessages())
                                <span class="badge badge-normal">{{ Auth::user()->countUnreadMessages() }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a href="{{ route('notifications.index') }}" class="collection-item grey lighten-3">
                            {{ trans('copy.a.notifications') }}
                            @if (Auth::user()->hasUnreadNotifications())
                                <span class="new badge">{{ Auth::user()->countUnreadNotifications() }}</span>
                            @endif
                        </a>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ trans('copy.titles.horses') }} <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('horses.index', Auth::user()->id) }}">{{ trans('copy.a.my_horses') }}</a>
                            </li>
                            <li class="divider"></li>
                            @foreach(Auth::user()->horses() as $horse)
                                <li>
                                    <a href="{{ route('horses.show', $horse->slug()) }}">{{ $horse->name }}</a>
                                </li>
                            @endforeach

                            <li class="divider"></li>
                            <li>
                                <a href="{{ route('horses.create') }}">
                                    {{ trans('copy.a.create_a_horse') }} <span class="badge badge-info"><i class="fa fa-plus-square-o"></i></span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ auth()->user()->fullName() }} <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('users.profiles.show', Auth::user()->id) }}">
                                    <span class="fa fa-user"></span> {{ Auth::user()->fullName() }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('settings.index') }}">
                                    {{ trans('copy.a.settings') }}
                                </a>
                            </li>
                            @if (Auth::user()->isAdmin())
                                <li>
                                    <a href="{{ route('admin.dashboard') }}">
                                        Admin Panel
                                    </a>
                                </li>
                            @endif
                            <li class="divider"></li>
                            <li>
                                <a href="{{ route('logout') }}">
                                    {{ trans('copy.a.logout') }}
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            @endif
        </div>
    </div>
</nav>
