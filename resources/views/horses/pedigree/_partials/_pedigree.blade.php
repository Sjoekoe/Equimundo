<div class="panel-body text-center">
    <h4 class="mar-btm">{{ $family->name() }}</h4>
    <p class="text-muted"><strong>{{ trans('forms.labels.breed') }}</strong> {{ trans('horses.breeds.' . $family->breed()) }}</p>
    <p class="text-muted"><strong>{{ trans('copy.p.born') }}</strong> {{ eqm_date($family->dateOfBirth(), 'Y') }}</p>
    <p class="text-muted"><strong>{{ trans('copy.p.life_number') }}</strong> {{ $family->lifeNumber() ? : '-' }}</p>
    <ul class="list-unstyled text-center pad-top mar-no clearfix">
        <li class="col-sm-4">
            <span class="text-lg">{{ count($family->statuses()) }}</span>
            <p class="text-muted text-uppercase">
                <small>{{ trans('copy.a.statuses') }}</small>
            </p>
        </li>
        <li class="col-sm-4">
            @if (! auth()->user()->isInHorseTeam($family))
                @if (Auth::user()->isFollowing($family))
                    {{ Form::open(['route' => ['follows.destroy', $family->id()], 'method' => 'DELETE']) }}
                    <button type="submit" class="btn btn-mint">{{ trans('copy.a.unfollow') . $family->name() }}</button>
                    {{ Form::close() }}
                @else
                    {{ Form::open(['route' => ['follows.store', $family->id()]]) }}
                    <button type="submit" class="btn btn-mint">{{ trans('copy.a.follow') . $family->name() }}</button>
                    {{ Form::close() }}
                @endif
            @endif
        </li>
        <li class="col-sm-4">
            <span class="text-lg">{{ count($family->followers()) }}</span>
            <p class="text-muted text-uppercase">
                <small>{{ trans('copy.a.followers') }}</small>
            </p>
        </li>
    </ul>

{{--<div class="panel-body text-center">
    <h4 class="mar-btm">{{ $family->name() }}</h4>
    <p class="text-muted">{{ trans('horses.breeds.' . $family->breed()) }}</p>
    <p class="text-muted"><strong>{{ trans('copy.p.born') }}</strong> {{ eqm_date($family->dateOfBirth(), 'Y') }}</p>
    <p class="text-muted"><strong>{{ trans('copy.p.life_number') }}</strong> {{ $family->lifeNumber() ? : '-' }}</p>
    <ul class="list-unstyled text-center pad-top mar-no clearfix">
        <li class="col-sm-4">
            <span class="text-lg">{{ count($family->statuses()) }}</span>
            <p class="text-muted text-uppercase">
                <small>{{ trans('copy.a.statuses') }}</small>
            </p>
        </li>
        <li class="col-sm-4">
            @if (! auth()->user()->isInHorseTeam($family))
                @if (Auth::user()->isFollowing($family))
                    {{ Form::open(['route' => ['follows.destroy', $family->id()], 'method' => 'DELETE']) }}
                    <button type="submit" class="btn btn-mint">{{ trans('copy.a.unfollow') . $family->name() }}</button>
                    {{ Form::close() }}
                @else
                    {{ Form::open(['route' => ['follows.store', $family->id()]]) }}
                    <button type="submit" class="btn btn-mint">{{ trans('copy.a.follow') . $family->name() }}</button>
                    {{ Form::close() }}
                @endif
            @endif
        </li>
        <li class="col-sm-4">
            <span class="text-lg">{{ count($family->followers()) }}</span>
            <p class="text-muted text-uppercase">
                <small>{{ trans('copy.a.followers') }}</small>
            </p>
        </li>
    </ul>
</div>--}}
