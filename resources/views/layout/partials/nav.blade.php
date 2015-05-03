<div class="primary title-bar">
    <div class="center title">
        <a class="navbar-brand" href="{{ route('home') }}">Horsestories</a>
    </div>
    <span class="left success"><a href="#">Left</a></span>
    <span class="right">
        @if (Auth::guest())
            <a href="{{ route('login') }}">Sign In</a>
            <a href="{{ route('register') }}">Register</a>
        @else
            <a href="{{ route('logout') }}">Logout</a>
        @endif
    </span>
</div>
