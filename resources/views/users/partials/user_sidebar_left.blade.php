<section id="left-sidebar" class="block-list medium-10">
    <h3 class="subheader">About You</h3>
    <ul>
        <li>
            <a href="#"><span class="fa fa-user"></span> {{ Auth::user()->username }}</a></li>
        <li> <a href="{{ route('users.profiles.edit') }}">Edit Profile</a> </li>
        <li><a href="#">Messages <span class="badge pull-right">1</span></a></li>
        <li><a href="#">Albums</a></li>
    </ul>
    <h3 class="subheader">
        Horses
        <a href="{{ route('horses.create') }}">
            <i class="fa fa-plus-square-o pull-right"></i>
        </a>
    </h3>
    <ul>
        @foreach(Auth::user()->horses as $horse)
            <li><a href="{{ route('horses.show', $horse->slug) }}">{{ $horse->name }}</a> </li>
        @endforeach
    </ul>
</section>

