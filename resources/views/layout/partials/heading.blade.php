<div class="row no-bottom-margin">
    <div class="col s12 heading" style="background-image: url({{ asset('/images/header.jpg') }})">
        <div class="heading-name left">
            <h1 class="teal-text">{{ $horse->name() }}</h1>
        </div>

        <div class="heading-button right">
            @if (auth()->user()->isInHorseTeam($horse))
                <a href="{{ route('horses.edit', $horse->slug()) }}" class="btn">{{ trans('copy.a.edit') . ' ' . $horse->name() }}</a>
            @else
                @include('horses.partials.follow-form')
            @endif
        </div>
    </div>
</div>
<div class="row">
    @include('horses.partials.menu-bar')
</div>
