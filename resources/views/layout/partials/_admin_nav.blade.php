<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header" style="padding: 0">
                <div class="profile-element">
                    <a href="{{ route('home') }}" style="padding: 0;">
                        <img src="{{ asset('images/Equimundo_Logo_long.png') }}" alt="" style="width: 100%;">
                    </a>
                </div>
                <div class="logo-element" style="padding: 0">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('images/Equimundo_Logo_neg.svg') }}" alt="" style="width: 100%">
                    </a>
                </div>
            </li>
            <li class="{{ Active::route('admin.dashboard', 'active') }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-dashboard"></i>
                    <span class="menu-title">
                        <strong>Dashboard</strong>
                    </span>
                </a>
            </li>
            <li class="{{ Active::route('admin.users', 'active') }}">
                <a href="{{ route('admin.users') }}">
                    <i class="fa fa-users"></i>
                    <span class="menu-title">
                        <strong>Users</strong>
                    </span>
                </a>
            </li>
            <li class="{{ Active::route('admin.horses.index', 'active') }}">
                <a href="{{ route('admin.horses.index') }}">
                    <i class="fa fa-tag"></i>
                    <span class="menu-title">
                        <strong>Horses</strong>
                    </span>
                </a>
            </li>
            <li class="{{ Active::route('admin.companies.index', 'active') }}">
                <a href="{{ route('admin.companies.index') }}">
                    <i class="fa fa-industry"></i>
                    <span class="menu-title">
                        <strong>Companies / Groups</strong>
                    </span>
                </a>
            </li>
            <li class="{{ Active::route('admin.searches.index', 'active') }}">
                <a href="{{ route('admin.searches.index') }}">
                    <i class="fa fa-search"></i>
                    <span class="menu-title">
                        <strong>Searches</strong>
                    </span>
                </a>
            </li>
            <li class="{{ Active::route('admin.advertisements*', 'active') }}">
                <a href="#">
                    <i class="fa fa-money"></i>
                    <span class="menu-title">
                        <strong>Advertisers</strong>
                    </span>
                    <i class="arrow"></i>
                </a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ Active::route('admin.advertisements.overview', 'active') }}">
                        <a href="{{ route('admin.advertisements.overview') }}">
                            Overview
                        </a>
                    </li>
                    <li class="{{ Active::route('admin.advertisements.companies.index', 'active') }}">
                        <a href="{{ route('admin.advertisements.companies.index') }}">
                            Companies
                        </a>
                    </li>
                    <li class="{{ Active::route('admin.advertisements.index', 'active') }}">
                        <a href="{{ route('admin.advertisements.index') }}">
                            Advertisements
                        </a>
                    </li>
                </ul>
            </li>
        </ul>

    </div>
</nav>
