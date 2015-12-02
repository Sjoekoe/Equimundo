<div class="row no-bottom-margin">
    <div class="col-md-12 heading" style="background-image: url({{ asset('/images/header.jpg') }})">
        <div class="heading-name pull-left">
            <h1>{{ $horse->name() }}</h1>
        </div>

        <div class="heading-button pull-right">
            @if (auth()->user()->isInHorseTeam($horse))
                <a href="{{ route('horses.edit', $horse->slug()) }}" class="btn btn-info">{{ trans('copy.a.edit_horse', ['horse' => $horse->name()]) }}</a>
            @else
                @include('horses.partials.follow-form')
            @endif
        </div>
    </div>
</div>
<div class="row">
    @include('horses.partials.menu-bar')
</div>
