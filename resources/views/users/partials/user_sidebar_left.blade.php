<ul id="nav-mobile" class="side-nav fixed user-left-sidebar grey lighten-3" style="left: 0px; top: 65px;">
    <h4>About You</h4>
    <div class="collection">
        <a href="#" class="collection-item grey lighten-3"><span class="fa fa-user"></span> {{ Auth::user()->username }}</a>
        <a href="{{ route('users.profiles.edit') }}" class="collection-item grey lighten-3">Edit Profile</a>
        <a href="{{ route('conversation.index') }}" class="collection-item grey lighten-3">
            Messages
            @if (Auth::user()->hasUnreadMessages())
                <span class="new badge">{{ Auth::user()->countUnreadMessages() }}</span>
            @endif
        </a>
    </div>
    <h4>
        Horses
    </h4>

    <div class="collection">
        <a href="{{ route('horses.create') }}" class="collection-item grey lighten-3">
            Create a horse <span class="badge"><i class="fa fa-plus-square-o"></i></span>
        </a>
        <a href="{{ route('horses.index', Auth::user()->id) }}" class="collection-item grey lighten-3">My Horses</a>
        @foreach(Auth::user()->horses as $horse)
            <a href="{{ route('horses.show', $horse->slug) }}" class="collection-item grey lighten-3">{{ $horse->name }}</a>
        @endforeach
    </div>
</ul>

