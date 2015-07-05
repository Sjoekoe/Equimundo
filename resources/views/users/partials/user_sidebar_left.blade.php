<ul id="nav-mobile" class="side-nav fixed user-left-sidebar grey lighten-3" style="left: 0px; top: 65px;">
    <h4>{{ trans('copy.titles.about_you') }}</h4>
    <div class="collection">
        <a href="{{ route('users.profiles.show', Auth::user()->id) }}" class="collection-item grey lighten-3"><span class="fa fa-user"></span> {{ Auth::user()->username }}</a>
        <a href="{{ route('users.profiles.edit') }}" class="collection-item grey lighten-3">{{ trans('copy.a.edit_profile') }}</a>
        <a href="{{ route('conversation.index') }}" class="collection-item grey lighten-3">
            {{ trans('copy.a.messages') }}
            @if (Auth::user()->hasUnreadMessages())
                <span class="new badge">{{ Auth::user()->countUnreadMessages() }}</span>
            @endif
        </a>
        <a href="{{ route('notifications.index') }}" class="collection-item grey lighten-3">
            {{ trans('copy.a.notifications') }}
            @if (Auth::user()->hasUnreadNotifications())
                <span class="new badge">{{ Auth::user()->countUnreadNotifications() }}</span>
            @endif
        </a>
    </div>

    <h4>{{ trans('copy.titles.horses') }}</h4>

    <div class="collection">
        <a href="{{ route('horses.create') }}" class="collection-item grey lighten-3">
            {{ trans('copy.a.create_a_horse') }} <span class="badge"><i class="fa fa-plus-square-o"></i></span>
        </a>
        <a href="{{ route('horses.index', Auth::user()->id) }}" class="collection-item grey lighten-3">{{ trans('copy.a.my_horses') }}</a>
        @foreach(Auth::user()->horses as $horse)
            <a href="{{ route('horses.show', $horse->slug) }}" class="collection-item grey lighten-3">{{ $horse->name }}</a>
        @endforeach
    </div>
</ul>

