<div class="row no-bottom-margin">
    <div class="col s12 heading" style="background-image: url(https://scontent-ams.xx.fbcdn.net/hphotos-xfp1/v/t1.0-9/10553388_10203915881569093_2920146316036226222_n.jpg?oh=6e110c44b513925b9e16c0d59d68b92e&oe=55DD955F)">
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
