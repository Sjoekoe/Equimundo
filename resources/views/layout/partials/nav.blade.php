<div class="navbar-fixed">
    <nav>
        <div class="nav-wrapper teal lighten-2">
            {{ Form::open(['route' => 'search', 'class' => 'left']) }}
                {{ Form::text('search', null, ['placeholder' => 'Search...']) }}
            {{ Form::close() }}
            <a href="{{ route('home') }}" class="brand-logo center">Horse Stories</a>
            <ul id="nav-mobile" class="left hide-on-med-and-down">
                @if (Auth::check())
                    <li><a href="{{ route('home') }}">{{ trans('copy.a.timeline') }}</a></li>
                @endif
            </ul>
            <ul class="right hide-on-med-and-down">
                @if (Auth::guest())
                    <li><a href="{{ route('login') }}">{{ trans('copy.a.sign_in') }}</a></li>
                    <li><a href="{{ route('register') }}">{{ trans('copy.a.sign_up') }}</a></li>
                @else
                    <li><a href="{{ route('logout') }}">{{ trans('copy.a.logout') }}</a></li>
                    <li><a href="{{ route('settings.index') }}">{{ trans('copy.a.settings') }}</a></li>
                    @if (Auth::user()->isAdmin())
                        <li><a href="{{ route('admin.dashboard') }}">Admin Panel</a></li>
                    @endif
                @endif
            </ul>
        </div>
    </nav>
</div>

