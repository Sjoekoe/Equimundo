<div id="mainnav-container">
    <div id="mainnav">
        <div id="mainnav-menu-wrap">
            <div class="nano">
                <div class="nano-content" tabindex="0">
                    <ul id="mainnav-menu" class="list-group">
                        <li class="{{ Active::route('admin.dashboard', 'active-link') }}">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="fa fa-dashboard"></i>
                                <span class="menu-title">
                                    <strong>Dashboard</strong>
                                </span>
                            </a>
                        </li>
                        <li class="{{ Active::route('admin.users', 'active-link') }}">
                            <a href="{{ route('admin.users') }}">
                                <i class="fa fa-users"></i>
                                <span class="menu-title">
                                    <strong>Users</strong>
                                </span>
                            </a>
                        </li>
                        <li class="{{ Active::route('admin.horses.index', 'active-link') }}">
                            <a href="{{ route('admin.horses.index') }}">
                                <i class="fa fa-smile-o"></i>
                                <span class="menu-title">
                                    <strong>Horses</strong>
                                </span>
                            </a>
                        </li>
                        <li class="{{ Active::route('admin.searches.index', 'active-link') }}">
                            <a href="{{ route('admin.searches.index') }}">
                                <i class="fa fa-search"></i>
                                <span class="menu-title">
                                    <strong>Searches</strong>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
