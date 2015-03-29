@if (Auth::user()->isFollowing($horse))
    {{ Form::open(['route' => ['follows.destroy', $horse->id], 'method' => 'DELETE']) }}
        <button type="submit" class="btn btn-default">{{ 'Unfollow ' . $horse->name }}</button>
    {{ Form::close() }}
@else
    {{ Form::open(['route' => 'follows.store']) }}
        {{ Form::hidden('horseIdToFollow', $horse->id) }}
        <button type="submit" class="btn btn-default">{{ 'Follow ' . $horse->name }}</button>
    {{ Form::close() }}
@endif
