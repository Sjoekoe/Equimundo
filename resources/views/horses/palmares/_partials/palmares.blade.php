<div class="row">
    <div class="col s12 palmares">
        <div class="col s5">
            <p>{{ trans('copy.p.event') }} {{ $palmares->event()->name() }}</p>
            <p>{{ trans('copy.p.date') }} {{ date('d F Y', strtotime($palmares->date())) }}</p>
        </div>
        <div class="col s5">
            <p>{{ trans('copy.p.discipline') }} {{ array_flatten(trans('disciplines.list'))[$palmares->discipline() - 1] }}</p>
            <p>{{ trans('copy.p.category') }} {{ $palmares->level() }}</p>
        </div>
        <div class="col s2">
            <h4>{{ $palmares->ranking }} {{ trans('copy.p.ranked') }}</h4>
            @if (Auth::user()->isHorseOwner($horse))
                <p><a href="{{ route('palmares.edit', $palmares->id()) }}">{{ trans('copy.a.edit') }}</a></p>
                <p><a href="{{ route('palmares.delete', $palmares->id()) }}">{{ trans('copy.a.delete') }}</a></p>
            @endif
            <p class="palmares-link"><a href="{{ route('statuses.show', $palmares->status()->id) }}">{{ trans('copy.a.show_story') }}</a></p>
        </div>
    </div>
</div>
