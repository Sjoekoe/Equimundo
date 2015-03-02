<div class="col-md-2 sidebar">
    <h3 class="sidebar-title">
        About You
    </h3>
    <hr/>
    <ul>
        <li> {{ Auth::user()->username }} </li>
        <li> <a href="{{ route('users.profiles.edit') }}">Edit Profile</a> </li>
        <li> Messages <span class="badge pull-right">4</span></li>
        <li> Albums </li>
    </ul>

    <h3 class="sidebar-title">
        Horses <a href="{{ route('horses.create') }}" class="pull-right">
            <i class="fa fa-plus-square-o"></i>
        </a>
    </h3>
    <hr/>
    <ul>
        @foreach(Auth::user()->horses as $horse)
            <li><a href="{{ route('horses.show', $horse->slug) }}">{{ $horse->name }}</a> </li>
        @endforeach
    </ul>
</div>