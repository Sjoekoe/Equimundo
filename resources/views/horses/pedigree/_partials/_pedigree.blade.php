@if ($family->users())
    <h4><a href="{{ route('horses.show', $family->slug()) }}" class="white-text">{{ $family->name() }}</a></h4>
@else
    <h4>{{ $family->name() }}</h4>
@endif
<p>{{ trans('copy.p.born') . ' ' . eqm_date($family->dateOfBirth()) }}</p>
{{--<p>{{ trans('copy.p.passed_away') . ' ' . $family->dateOfDeath() ? date('Y', strtotime($family->dateOfDeath())) : '-' }}</p>--}}
<p>{{ trans('copy.p.life_number') . ' ' . $family->lifeNumber() ? : '-' }}</p>

@if (auth()->user()->isInHorseTeam($horse))
    <p>
        <a href="{{ route('pedigree.edit', $family->slug()) }}">{{ trans('copy.a.edit') }}</a> /
        <a href="{{ route('pedigree.delete', $family->id()) }}">{{ trans('copy.a.delete') }}</a>
    </p>
@endif
