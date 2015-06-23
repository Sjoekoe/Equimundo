<div class="navbar-fixed">
    <nav>
        <div class="nav-wrapper teal lighten-2">
            <a href="{{ route('home') }}" class="brand-logo center">Horse Stories</a>
            <ul id="nav-mobile" class="left hide-on-med-and-down">
                @if (Auth::check())
                    <li><a href="{{ route('home') }}">Timeline</a></li>
                @endif
            </ul>
            <ul class="right hide-on-med-and-down">
                @if (Auth::guest())
                    <li><a href="{{ route('login') }}">Sign In</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                @else
                    <li><a href="{{ route('logout') }}">Logout</a></li>
                    @if (Auth::user()->isAdmin())
                        <li><a href="#">Admin Panel</a></li>
                    @endif
                @endif
            </ul>
        </div>
    </nav>
</div>

