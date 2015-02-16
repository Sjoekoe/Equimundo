<div class="col-md-3">
    {{ Auth::user()->username }} <br/>
    <a href="{{ route('users.profiles.edit') }}">Edit Profile</a> <br/>
    Messages <br/>
    Horses <a href="{{ route('horses.create') }}">+</a> <br/>

    @foreach(Auth::user()->horses as $horse)
        {{ $horse->name }} <br/>
    @endforeach
</div>