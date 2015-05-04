<div class="primary title-bar">
    <div class="center title">
        <a class="navbar-brand" href="{{ route('home') }}">Horse Stories</a>
    </div>
    <span class="left success"><a href="#">Left</a></span>
    <span class="right">
        <div class="menu-group-right">
            @if (Auth::guest())
                <ul class="primary condense menu-bar">
                    <li><a href="{{ route('login') }}">Sign In</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                </ul>
            @else
                <ul class="primary menu-bar">
                    <li><a href="{{ route('logout') }}">Logout</a></li>
                    @if (Auth::user()->isAdmin())
                        <li><a href="#">Admin Panel</a></li>
                    @endif
                </ul>
            @endif
        </div>
    </span>
</div>
