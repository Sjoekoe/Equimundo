@if ($family->user_id)
    <h4><a href="{{ route('horses.show', $family->slug) }}" class="white-text">{{ $family->name }}</a></h4>
@else
    <h4>{{ $family->name }}</h4>
@endif
<p>{{ trans('copy.p.born') . ' ' . date('Y', strtotime($family->date_of_birth)) }}</p>
<p>{{ trans('copy.p.passed_away') . ' ' . $family->date_of_death ? date('Y', strtotime($family->date_of_death)) : '-' }}</p>
<p>{{ trans('copy.p.life_number') . ' ' . $family->life_number ? : '-' }}</p>

@if (Auth::user()->isHorseOwner($horse))
    <p>
        <a href="{{ route('pedigree.edit', $family->id) }}">{{ trans('copy.a.edit') }}</a> /
        <a href="{{ route('pedigree.delete', $family->id) }}">{{ trans('copy.a.delete') }}</a>
    </p>
@endif
