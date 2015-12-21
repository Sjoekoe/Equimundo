@if (Auth::user()->isFollowing($horse))
    {{ Form::open(['route' => ['follows.destroy', $horse->id()], 'method' => 'DELETE']) }}
        <button type="submit" class="btn btn-primary padding only-margin-tr">{{ trans('copy.a.unfollow') . $horse->name }}</button>
    {{ Form::close() }}
@else
    {{ Form::open(['route' => ['follows.store', $horse->id()]]) }}
        <button type="submit" class="btn btn-primary padding only-margin-tr">{{ trans('copy.a.follow') . $horse->name() }}</button>
    {{ Form::close() }}
@endif
