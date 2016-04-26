@if (Auth::user()->isFollowing($horse))
    {{ Form::open(['route' => ['follows.destroy', $horse->id()], 'method' => 'DELETE']) }}
        <button type="submit" class="btn btn-sm btn-mint">{{ trans('copy.a.unfollow') }}</button>
    {{ Form::close() }}
@else
    {{ Form::open(['route' => ['follows.store', $horse->id()]]) }}
        <button type="submit" class="btn btn-sm btn-mint">{{ trans('copy.a.follow') }}</button>
    {{ Form::close() }}
@endif
