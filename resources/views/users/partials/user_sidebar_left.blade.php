<div class="col-md-3">
    {{ Auth::user()->username }} <br/>
    <a href="{{ route('users.profiles.edit') }}">Edit Profile</a> <br/>
    Messages <br/>
    Horses
</div>